const fs = require('fs');
const shell = require('shelljs');

const ZIP_DIR = fs.mkdtempSync('/tmp/readlinks');
const SRC_DIR = shell.pwd().stdout;

shell.echo(`Building in tmp dir: ${ZIP_DIR}`);

shell.echo('Checking out index...');
shell.exec(`git checkout-index --quiet --all --force --prefix=${ZIP_DIR}/`);
shell.echo('Done!');

shell.echo('Installing dependencies...');
shell.cd(ZIP_DIR);
shell.exec('npm i');
shell.exec('composer install --quiet --no-dev --optimize-autoloader &>/dev/null');
shell.echo('Done!');

shell.echo('Building assets...');
shell.exec('npm run build');
shell.echo('Done!');

shell.echo('Removing unwanted development files using .svnignore...');
shell.rm('-rf', shell.cat(`${ZIP_DIR}/.svnignore`).stdout.split('\n'));
shell.echo('Done!');

shell.echo('Building production release zip...');
shell.exec('zip -r readlinks * --quiet');
shell.mv('readlinks.zip', `${SRC_DIR}/readlinks.zip`);
shell.echo('Done!');
