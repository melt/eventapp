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
    const APP_EMAIL = "per.d.jonsson@gmail.com";
    const FACEBOOK_APP_ID = "211329565552399";
    const FACEBOOK_APP_SECRET = "0bbb416cd5bd7ff8cb618eeb4e848d15";
}

namespace nmvc\internal {
    modules_using(
            "jquery"
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
    const FORCE_ERROR_DISPLAY = true;
    const MAINTENANCE_MODE = true;
    const NO_MAINTENANCE_CONTROLLERS = 'nmvc\IndexController';
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
    const FROM_ADDRESS = '';
    const FROM_NAME = '';
    const SPOOL_RETRY_INTERVAL_SECONDS = 300;
    const SMTP_FROM_HOST = NULL;
    const SMTP_TIMEOUT = 10;
    const SMTP_HOST = 'smtp.gmail.com';
    const SMTP_PORT = 587;
    const SMTP_AUTH_ENABLE = true;
    const SMTP_AUTH_PASSWORD = '2S268885';
    const SMTP_AUTH_USER = 'sendmail@omnicloud.org';
    const SMTP_TLS_ENABLE = true;
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

namespace nmvc\jquery\config {
    const JQUERY_UI_THEME = "/static/jq-ui-theme/jquery-ui-1.8.6.custom.css";
    const INCLUDE_JQUERY_JSTREE = true;
    const INCLUDE_JQUERY_DATATABLES = true;
    const INCLUDE_JQUERY_RESIZE = true;
    const INCLUDE_JQUERY_COOKIE = true;
    const INCLUDE_JQUERY_HOTKEYS = true;
    const INCLUDE_JQUERY_ALERTS = true;
    const INCLUDE_JQUERY_CORNER = false;
    const INCLUDE_JQUERY_LIGHTBOX = false;
    const INCLUDE_JQUERY_AUTOCOMPLETE = false;
    const INCLUDE_JQUERY_AUTORESIZE = true;
    const INCLUDE_JQUERY_FORM = true;
}