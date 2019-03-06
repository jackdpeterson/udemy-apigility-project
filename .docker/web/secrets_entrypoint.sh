#!/usr/bin/env bash


function interpolate_env_vars {
    # Ensure we have a bucket to request variables from
    echo "Starting environment variable interpolation..."

    if [ -z "$SECRETS_BUCKET_NAME" ]; then
      echo >&2 'error: missing SECRETS_BUCKET_NAME environment variable'
      exit 2
    fi

    # Ensure we have a FAMILY to pull from
    if [ -z "${FAMILY}" ]; then
        echo >&2 "error: Missing FAMILY environment variable. This is application name."
        exit 2
    fi

    # Ensure we have an APPLICATION_ENVIRONMENT to pull from
    if [ -z "${APPLICATION_ENVIRONMENT}" ]; then
        echo >&2 "error: Missing APPLICATION_ENVIRONMENT environment variable."
        exit 2
    fi

    # Load the S3 secrets file contents into the environment variables
    OUTPUT=$(aws s3 cp s3://${SECRETS_BUCKET_NAME}/${FAMILY}/${APPLICATION_ENVIRONMENT}.env - | grep -v '^\s*%' | grep -v '^#.*$')

    if [ $? -gt 0 ]; then
        echo >&2 "There was an error downloading the environment secrets file for this specific branch! Output: ${OUTPUT}"
        echo >&2 "Now attempting default.env":
        OUTPUT=$(aws s3 cp s3://${SECRETS_BUCKET_NAME}/${FAMILY}/default.env - | grep -v '^\s*%' | grep -v '^#.*$')
        if [ $? -gt 0 ]; then
            echo >&2 "There was an error attempting to use default.env! output: ${OUTPUT}"
            exit 2
        fi
    fi


    for LINE_TO_EXPORT in ${OUTPUT}; do
        LINE_TO_EXPORT=$(echo "${LINE_TO_EXPORT}" | sed -e 's/^/export /')
        echo "running: ${LINE_TO_EXPORT}"
        ${LINE_TO_EXPORT}
        if [ $? -gt 0 ]; then
            echo >&2 "Error with export: ${EXPORT_OUTPUT}"
            exit 2
        fi
    done

    echo "finished environment variable interpolation. Environment configuration: "
    CURRENT_ENV=$(printenv | sed -e 's/^.*password.*$/FIELD_OBFUSCATED_FOR_SECURITY=true/i' | sort)
    echo ${CURRENT_ENV}
}

## Interpolate variables by default
if [ -z "${SKIP_ENV_INTERPOLATION}" ]; then
    interpolate_env_vars
fi

exec "$@"