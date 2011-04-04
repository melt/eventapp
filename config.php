<?php
/**
 * Contains the configuration for this application.
 *
 * nanoMVC configuration options are named constants that resides in the
 * namespace \nanomvc\$MODULE\config where $MODULE is the module that uses the
 * configuration option.
 *
 * NanoMVC will automatically insert missing directives into this file
 * so don't be suprised when it starts editing itself.
 */

namespace nmvc\internal {
    modules_using(
        // Add modules that your application uses here.
    );
}

namespace nmvc\core\config {
    const PHP_BINARY = 'php';
    const SESSION_ENFORCE_HTTPS = false;
    const SESSION_DOMAIN = NULL;
    const DEFAULT_LANGUAGE = 'en';
    const RECAPTCHA_PUBLIC_KEY = '';
    const RECAPTCHA_PRIVATE_KEY = '';
    const DISPLAY_DEVMODE_NOTICE = true;
    const DOWN_MESSAGE = '';
    const IGNORE_64_BIT_WARNING = false;
    const TRANSLATION_MIN_Q = 0.4;
    const TRANSLATION_ENABLED = false;
    const PEAR_AUTOLOAD = false;
    const ERROR_LOG = NULL;
    const FORCE_ERROR_FLAGS = false;
    const FORCE_ERROR_DISPLAY = false;
    const MAINTENANCE_MODE = true;
    const DEVELOPER_KEY = '';
}


namespace nmvc\db\config {
    const STORAGE_ENGINE = 'auto';
    const REQUEST_LEVEL_TRANSACTIONALITY = true;
    const DEBUG_QUERY_BENCHMARK = false;
    const USE_TRIGGER_SEQUENCING = true;
    const PREFIX = '';
    const NAME = 'u10006_event';
    const PORT = 5000;
    const PASSWORD = '5a4e40911eae0559';
    const USER = 'u10006_event';
    const HOST = 'webbhotell.omnicloud.org';
}


namespace nmvc\mail\config {
    const SPOOL_RETRY_INTERVAL_SECONDS = 300;
    const SMTP_AUTH_PASSWORD = 'password';
    const SMTP_AUTH_USER = 'user';
    const SMTP_AUTH_ENABLE = false;
    const SMTP_TLS_ENABLE = false;
    const SMTP_FROM_HOST = NULL;
    const SMTP_TIMEOUT = 10;
    const SMTP_PORT = 25;
    const SMTP_HOST = 'localhost';
    const FROM_ADDRESS = '';
    const FROM_NAME = '';
}


namespace nmvc\userx\config {
    const LAST_DENY_AUTOREDIRECT = true;
    const SHELL_LOGIN = false;
    const MULTIPLE_GROUPS = false;
    const MULTIPLE_IDENTITIES = false;
    const HASHING_ALGORITHM = 'crypt';
    const SOFT_403 = false;
    const REMEMBER_ME_DAYS = 356;
    const SESSION_TIMEOUT_MINUTES = false;
}
