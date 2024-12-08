# To learn more about how to use Nix to configure your environment
# see: https://developers.google.com/idx/guides/customize-idx-env
{ pkgs, ... }: {
  # Which nixpkgs channel to use.
  channel = "stable-24.05"; # or "unstable"

  packages = [
    pkgs.php82
    pkgs.php82Packages.composer
    pkgs.nodejs_20
  ];

  services.mysql = {
    enable = true;
    package = pkgs.mysql80;
  };

  # Sets environment variables in the workspace
  env = {
    APP_NAME= "Laravel";
    APP_ENV= "local";
    APP_KEY= "";
    APP_DEBUG=true;
    APP_URL="http://localhost";

    LOG_CHANNEL="stack";
    LOG_DEPRECATIONS_CHANNEL=null;
    LOG_LEVEL="debug";

    DB_CONNECTION="mysql";
    DB_HOST="127.0.0.1";
    DB_PORT=3306;
    DB_DATABASE="laravel";
    DB_USERNAME="root";
    DB_PASSWORD="";

    BROADCAST_DRIVER="log";
    CACHE_DRIVER="file";
    FILESYSTEM_DISK="local";
    QUEUE_CONNECTION="sync";
    SESSION_DRIVER="file";
    SESSION_LIFETIME=120;

    MEMCACHED_HOST="127.0.0.1";

    REDIS_HOST="127.0.0.1";
    REDIS_PASSWORD=null;
    REDIS_PORT=6379;

    MAIL_MAILER="smtp";
    MAIL_HOST="mailpit";
    MAIL_PORT=1025;
    MAIL_USERNAME=null;
    MAIL_PASSWORD=null;
    MAIL_ENCRYPTION=null;
    MAIL_FROM_ADDRESS="hello@example.com";
    MAIL_FROM_NAME="Laravel";

    AWS_ACCESS_KEY_ID="";
    AWS_SECRET_ACCESS_KEY="";
    AWS_DEFAULT_REGION="us-east-1";
    AWS_BUCKET="";
    AWS_USE_PATH_STYLE_ENDPOINT=false;

    PUSHER_APP_ID="";
    PUSHER_APP_KEY="";
    PUSHER_APP_SECRET="";
    PUSHER_HOST="";
    PUSHER_PORT=443;
    PUSHER_SCHEME="https";
    PUSHER_APP_CLUSTER="mt1";

    VITE_APP_NAME="Laravel";
    VITE_PUSHER_APP_KEY="";
    VITE_PUSHER_HOST="";
    VITE_PUSHER_PORT=443;
    VITE_PUSHER_SCHEME="https";
    VITE_PUSHER_APP_CLUSTER="mt1";

  };
  
  idx = {
    # Search for the extensions you want on https://open-vsx.org/ and use "publisher.id"
    # extensions = [
    #   # "vscodevim.vim"
    # ];
    # workspace = {
    #   # Runs when a workspace is first created with this dev.nix file
    #   onCreate = {
    #     # Example: install JS dependencies from NPM
    #     # npm-install = "npm install";
    #     # Open editors for the following files by default, if they exist:
    #     default.openFiles = [ "README.md" "Laravel/resources/views/home.blade.php" ];
    #   };
    #   # To run something each time the workspace is (re)started, use the onStart hook
    # };
    # # Enable previews and customize configuration
    # previews = {
    #   enable = true;
    #   previews = {
    #     web = {
    #       command = ["cd" "/Laravel" "php" "artisan" "serve" "--port" "$PORT" "--host" "0.0.0.0"];
    #       manager = "web";
    #     };
    #   };
    # };
  };
}