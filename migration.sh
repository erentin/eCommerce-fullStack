#!/bin/bash

## Constants

RED="\033[0;31m"
BRED="\033[1;31m"
BGREEN="\033[1;32m"
BYELLOW="\033[1;33m"
BBLUE="\033[1;34m"
BPINK="\033[1;35m"
WHITE="\033[0m"
NC="\033[0m"
ERROR_LABEL="${BRED}error: ${NC}"
SUCCESS_LABEL="${BGREEN}success: ${NC}"
PENDING_LABEL="${BYELLOW}pending: ${NC}"
INFO_LABEL="${BBLUE}info: ${NC}"
WARNING_LABEL="${BYELLOW}warning: ${NC}"

## Utils Functions

# Rollback to previous Meilisearch version in case something went wrong

previous_version_rollback() {

    echo -e "${ERROR_LABEL}Meilisearch update to $meilisearch_version failed." >&2
    echo -e "${INFO_LABEL}Rollbacking to previous version ${BPINK}$current_meilisearch_version${NC}." >&2
    echo -e "${INFO_LABEL}Recovering..." >&2
    mv /tmp/meilisearch /usr/bin/meilisearch
    echo -e "${SUCCESS_LABEL}Recover previous data.ms." >&2
    mv /tmp/data.ms /var/lib/meilisearch/data.ms
    echo -e "${INFO_LABEL}Restarting Meilisearch." >&2
    systemctl restart meilisearch
    systemctl_status exit
    echo -e "${SUCCESS_LABEL}Previous Meilisearch version ${BPINK}$current_meilisearch_version${NC} restarted correctly with its data recovered." >&2
    delete_temporary_files
    echo -e "${WARNING_LABEL}Update Meilisearch from ${BPINK}$current_meilisearch_version${NC} to ${BPINK}$meilisearch_version${NC} failed. Rollback to previous version successfull." >&2
    echo -e "${BGREEN}Meilisearch service up and running in version ${NC} ${BPINK}$meilisearch_version${NC}."
    exit
}

# Check if Meilisearch systemctl process is Active
systemctl_status() {
    systemctl status meilisearch | grep -E 'Active: active \(running\)' -q
    grep_status_code=$?
    callback_1=$1
    callback_2=$2
    if [ $grep_status_code -ne 0 ]; then
        echo -e "${ERROR_LABEL}Meilisearch Service is not Running. Please start Meilisearch." >&2
        if [ ! -z "$callback_1" ]; then
            $callback_1
        fi

        if [ ! -z "$callback_2" ]; then
            $callback_2
        fi
    fi
}

# Delete temporary files
delete_temporary_files() {
    echo -e "${INFO_LABEL}Cleaning temporary files..."
    if [ -f "meilisearch" ]; then
        rm meilisearch
        echo -e "${SUCCESS_LABEL}Delete temporary meilisearch binary."
    fi

    if [ -f "logs" ]; then
        rm logs
        echo -e "${SUCCESS_LABEL}Delete temporary logs file."
    fi

    local dump_file="/var/opt/meilisearch/dumps/$dump_id.dump"
    if [ -f $dump_file ]; then
        rm "$dump_file"
        echo -e "${SUCCESS_LABEL}Delete temporary dump file."
    fi

}

# Check if Meilisearch arguments are provided
check_args() {
    if [ $1 -eq 0 ]; then
        echo -e "${ERROR_LABEL}$2"
        exit
    fi
}

# Check if latest command exit status is not an error
check_last_exit_status() {
    status=$1
    message=$2
    callback_1=$3
    callback_2=$4

    if [ $status -ne 0 ]; then
        echo -e "${ERROR_LABEL}$message."
        if [ ! -z "$callback_1" ]; then
            ($callback_1)
        fi
        if [ ! -z "$callback_2" ]; then
            ($callback_2)
        fi
        exit
    fi
}

# Check if the API key is defined is the environment variable
check_api_key() {
    if [ -z $MEILISEARCH_MASTER_KEY ]; then
        echo -e "${WARNING_LABEL}MEILISEARCH_MASTER_KEY is not available in the environment variables. If you have an API key, set it with the following command 'export MEILISEARCH_MASTER_KEY=YOUR_API_KEY'"
    fi
}

## Main Script

#
# Current Running Meilisearch
#

# Confirm that the API key is defined in the env variables.
check_api_key

echo -e "${SUCCESS_LABEL}Starting version update of Meilisearch."

# Check if Meilisearch Service is running
systemctl_status exit

# Check if version argument was provided on script launch
check_args $# "Meilisearch version not provided as arg.\nUsage: sh update_meilisearch_version.sh [vX.X.X]"

# Version to update Meilisearch to.
meilisearch_version=$1

echo -e "${SUCCESS_LABEL}Requested Meilisearch version: ${BPINK}$meilisearch_version${NC}."

# Current Meilisearch version
# FIXME: Should work without master key provided see issue #44
current_meilisearch_version=$(
    curl -X GET 'http://localhost:7700/version' --header "Authorization: Bearer $MEILISEARCH_MASTER_KEY" -s --show-error |
        cut -d '"' -f 12
)

# Check if curl version request is successfull.
check_last_exit_status $? "Version request 'GET /version' request failed."
echo -e "${SUCCESS_LABEL}Current running Meilisearch version: ${BPINK}$current_meilisearch_version${NC}."

#
# Back Up Dump
#

# Create dump for migration in case of incompatible versions
echo -e "${INFO_LABEL}Creation of a dump in case new version does not have compatibility with the current Meilisearch."
dump_return=$(curl -X POST 'http://localhost:7700/dumps' --header "Authorization: Bearer $MEILISEARCH_MASTER_KEY" --show-error -s)

# Check if curl request was successfull.
check_last_exit_status $? "Dump creation 'POST /dumps' request failed."

if echo $current_meilisearch_version | grep -E "^[0].2[01234567]{1}.[0-9]+.*" -q; then
    # Get the dump id
    dump_id=$(echo $dump_return | cut -d '"' -f 4)
    echo -e "${INFO_LABEL}Creating dump id with id: $dump_id."

    # Wait for Dump to be created
    while true
    do
        curl -X GET "http://localhost:7700/dumps/$dump_id/status" \
        --header "Authorization: Bearer $MEILISEARCH_MASTER_KEY" --show-error -s -i > curl_dump_creation_response
        cat curl_dump_creation_response | grep "200 OK" -q
        check_last_exit_status $? "Request to /dumps/$dump_id/status failed" delete_temporary_files
        if cat curl_dump_creation_response | grep '"status":"done"' -q; then
            rm curl_dump_creation_response
            break
        elif cat curl_dump_creation_response | grep '"status":"failed"' -q; then
            rm curl_dump_creation_response
            delete_temporary_files
            echo -e "${ERROR_LABEL}Meilisearch could not create the dump:\n ${response}" >&2
            exit
        fi
        echo -e "${PENDING_LABEL}Meilisearch is still creating the dump: $dump_id."
        sleep 2
    done
else
    # Get the task uid
    task_uid=$(echo $dump_return | grep -o -E "\"taskUid\":[0-9]+" | awk -F\: '{print $2}')
    echo -e "${INFO_LABEL}Creating dump with task uid: $task_uid."

    while true
    do
        curl -X GET "http://localhost:7700/tasks/$task_uid" \
        --header "Authorization: Bearer $MEILISEARCH_MASTER_KEY" --show-error -s -i > curl_dump_creation_response
        cat curl_dump_creation_response | grep "200 OK" -q
        check_last_exit_status $? "Request to /tasks/$task_uid failed"
        if cat curl_dump_creation_response | grep '"status":"succeeded"' -q; then # | awk -F\: '{print $2}'
            dump_id=$(cat curl_dump_creation_response | grep -o -E "\"dumpUid\":\"(.{8}-.{9})\"" | awk -F\: '{print $2}' | tr -d \")
            echo $dump_id
            rm curl_dump_creation_response
            break
        elif cat curl_dump_creation_response | grep '"status":"failed"' -q; then
            rm curl_dump_creation_response
            delete_temporary_files
            echo -e "${ERROR_LABEL} Failed to create the dump."
            exit
        fi
        echo -e "${PENDING_LABEL}Meilisearch is still creating the dump with task uid: $task_uid."
        sleep 2
    done
fi

echo -e "${SUCCESS_LABEL}Meilisearch finished creating the dump: $dump_id."

#
# New MeiliSsarch
#

# Download Meilisearch of the right version
echo -e "${INFO_LABEL}Downloading Meilisearch version ${BPINK}$meilisearch_version${NC}."
response=$(curl "https://github.com/meilisearch/meilisearch/releases/download/$meilisearch_version/meilisearch-linux-amd64" --output meilisearch --location -s --show-error)

check_last_exit_status $? \
    "Request to download Meilisearch $meilisearch_version release failed." \
    delete_temporary_files

# Give read and write access to meilisearch binary
chmod +x meilisearch

# Check if Meilisearch binary is not corrupted
if file meilisearch | grep "ELF 64-bit LSB shared object" -q; then
    echo -e "${SUCCESS_LABEL}Successfully downloaded Meilisearch version $meilisearch_version."
else
    echo -e "${ERROR_LABEL}Meilisearch binary is corrupted.\n\
  It may be due to: \n\
  - Invalid version syntax. Provided: $meilisearch_version, expected: vX.X.X. ex: v0.22.0 \n\
  - Rate limiting from GitHub." >&2
    delete_temporary_files
    exit
fi

echo -e "${INFO_LABEL}Stopping Meilisearch Service to update the version."
## Stop meilisearch running
systemctl stop meilisearch # stop the service to update the version

## Move the binary of the current Meilisearch version to the temp folder
echo -e "${INFO_LABEL}Keep a temporary copy of previous Meilisearch."
mv /usr/bin/meilisearch /tmp

# Keep cache of previous data.ms in case of failure
cp -r /var/lib/meilisearch/data.ms /tmp/
echo -e "${INFO_LABEL}Keep a temporary copy of previous data.ms."

# Remove data.ms
rm -rf /var/lib/meilisearch/data.ms
echo -e "${INFO_LABEL}Delete current Meilisearch's data.ms"

## Move new Meilisearch binary to the systemctl directory containing the binary
echo -e "${INFO_LABEL}Update Meilisearch version."
cp meilisearch /usr/bin/meilisearch

# Run Meilisearch
# TODO: `import-dump` may change name for v1, it should be added in the integration-guide issue
# https://github.com/meilisearch/meilisearch/issues/3132
./meilisearch --db-path /var/lib/meilisearch/data.ms --env production --import-dump "/var/opt/meilisearch/dumps/$dump_id.dump" --master-key $MEILISEARCH_MASTER_KEY 2>logs &
echo -e "${INFO_LABEL}Run local $meilisearch_version binary importing the dump and creating the new data.ms."

sleep 2

# Needed conditions due to bug in Meilisearch #1701
if cat logs | grep "Error: No such file or directory (os error 2)" -q; then
    # If dump was empty no import is needed
    echo -e "${SUCCESS_LABEL}Empty database! Importing of no data done."
else
    echo -e "${INFO_LABEL}Check if local $meilisearch_version started correctly."
    # Check if local meilisearch started correctly `./meilisearch ..`
    if ps | grep "meilisearch" -q; then
        echo -e "${SUCCESS_LABEL}Meilisearch started successfully and is importing the dump."
    else
        echo -e "${ERROR_LABEL}Meilisearch could not start: \n ${BRED}$(cat logs)${NC}." >&2
        # In case of failed start rollback to initial version
        previous_version_rollback
    fi

    ## Wait for pending dump indexation
    while true
    do
    	curl -X GET 'http://localhost:7700/health' \
        --header "Authorization: Bearer $MEILISEARCH_MASTER_KEY" --show-error -s -i > curl_dump_index_response
	cat curl_dump_index_response | grep "200 OK" -q
	check_last_exit_status $? "Request to /health failed"
	if cat curl_dump_index_response | grep '"status":"available"' -q; then
		rm curl_dump_index_response
		break
	else
		rm curl_dump_index_response
		echo "${ERROR_LABEL} Failed to index the dump"
		exit
	fi
	sleep 2
    done
    echo -e "${SUCCESS_LABEL}Meilisearch is done indexing the dump."

    # Kill local Meilisearch process
    echo -e "${INFO_LABEL}Kill local Meilisearch process."
    pkill meilisearch
fi

regex_version="v[1-9]+\.[0-9]+\.[0-9]+"
if [[ $meilisearch_version =~ $regex_version ]]
then
    sed -i 's/--dumps-dir/--dump-dir/' /etc/systemd/system/meilisearch.service
fi

## Restart Meilisearch
systemctl restart meilisearch
echo -e "${INFO_LABEL}Meilisearch $meilisearch_version is starting."

# In case of failed restart rollback to initial version
systemctl_status previous_version_rollback exit
echo -e "${SUCCESS_LABEL}Meilisearch $meilisearch_version service started succesfully."

# Delete temporary files to leave the environment the way it was initially
delete_temporary_files

echo -e "${BGREEN}Migration complete. Meilisearch is now in version ${NC} ${BPINK}$meilisearch_version${NC}."
echo -e "${BGREEN}Meilisearch service up and running in version ${NC} ${BPINK}$meilisearch_version${NC}."
