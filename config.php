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
namespace nmvc {
    const APP_NAME = "Sandbox Events";
    const APP_EMAIL = "per.d.jonsson+spam@gmail.com";
    const FACEBOOK_APP_ID = "211329565552399";
    const FACEBOOK_APP_SECRET = "0bbb416cd5bd7ff8cb618eeb4e848d15";
}

namespace nmvc\internal {
    modules_using(
            //"jquery",
            "data_tables"
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
    const DOWN_MESSAGE = 'Application is currently under development. Please check back later or contact per.d.jonsson@gmail.com.';
    const IGNORE_64_BIT_WARNING = false;
    const TRANSLATION_MIN_Q = 0.4;
    const TRANSLATION_ENABLED = false;
    const PEAR_AUTOLOAD = false;
    const ERROR_LOG = NULL;
    const FORCE_ERROR_FLAGS = false;
    const FORCE_ERROR_DISPLAY = true;
    const MAINTENANCE_MODE = false;
    const NO_MAINTENANCE_CONTROLLERS = 'nmvc\IndexController';
    const DEVELOPER_KEY = 'BLOODYMARY';
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
    const SMTP_TIMEOUT = 10;
    const SMTP_PORT = 6000;
    const SMTP_HOST = '127.0.0.1';
    const SMTP_FROM_HOST = "va1ehf69kgihsclflfd.localhost";
    const SMTP_AUTH_ENABLE = false;
    const SMTP_AUTH_PASSWORD = 'password';
    const SMTP_AUTH_USER = 'user';
    const SMTP_TLS_ENABLE = false;
}

namespace nmvc\userx\config {
    const LAST_DENY_AUTOREDIRECT = true;
    const SHELL_LOGIN = false;
    const MULTIPLE_GROUPS = false;
    const MULTIPLE_IDENTITIES = false;
    const HASHING_ALGORITHM = 'crypt';
    const SOFT_403 = "/outside/forbidden_403";
    const REMEMBER_ME_DAYS = 356;
    // Extremely long session timeout
    const SESSION_TIMEOUT_MINUTES = 0x7fffffff;
}

namespace nmvc\js\config {
    const INCLUDE_LESS_CSS = false;
    const INCLUDE_JQUERY_JSTREE = false;
    const INCLUDE_JQUERY_HOTKEYS = false;
    const INCLUDE_JQUERY_RESIZE = false;
    const INCLUDE_JQUERY_FORM = true;
    const INCLUDE_JQUERY_COOKIE = true;
    const INCLUDE_JQUERY_AUTORESIZE = false;
    const INCLUDE_JQUERY_AUTOCOMPLETE = true;
    const INCLUDE_JQUERY_DATATABLES = true;
    const INCLUDE_JQUERY_LIGHTBOX = false;
    const INCLUDE_JQUERY_CORNER = true;
    const INCLUDE_JQUERY_ALERTS = true;
    const JQUERY_UI_THEME = 'smoothness';
}