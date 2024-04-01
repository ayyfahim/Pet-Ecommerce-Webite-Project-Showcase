# exit on command failure
set -e

# fancy comment
echo '# ---------------------------------------------------------------------------- #'
echo '#                                 script start                                 #'
echo '# ---------------------------------------------------------------------------- #'

read -rp "Pull Only? [y/n]"
if [[ ${REPLY, } =~ ^(y|yes)$ ]]; then
  git pull
else
  # cmnds
  php artisan down
  git reset --hard
  git pull

  # migration
  echo
  echo '# ---------------------------------------------------------------------------- #'
  echo
  read -rp "Reset Database? [y/n]"
  if [[ ${REPLY, } =~ ^(y|yes)$ ]]; then
    echo
    echo '# ---------------------------------------------------------------------------- #'
    echo
    read -rp "The Database will be removed , are you sure? [y/n]"
    if [[ ${REPLY, } =~ ^(y|yes)$ ]]; then
      php artisan migrate:fresh --seed
      chmod -R 777 storage/
      php artisan storage:link -q
    fi
  fi
  # composer
  echo
  echo '# ---------------------------------------------------------------------------- #'
  echo
  read -rp "Run composer install? [y/n]"
  if [[ ${REPLY, } =~ ^(y|yes)$ ]]; then
    composer install
    composer dump
  fi
  # npm
  echo
  echo '# ---------------------------------------------------------------------------- #'
  echo
  read -rp "Run npm install? [y/n]"
  if [[ ${REPLY, } =~ ^(y|yes)$ ]]; then
    npm install
  fi
  echo
  echo '# ---------------------------------------------------------------------------- #'
  echo
  echo "Building React..."

  NODE_ENV=production && node_modules/webpack/bin/webpack.js --no-progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js

  php artisan apidoc:generate --force
  chmod +x ./update-data.sh
  php artisan up
fi
# fancy comment
echo
echo '# ---------------------------------------------------------------------------- #'
echo '#                                script finished                               #'
echo '# ---------------------------------------------------------------------------- #'
