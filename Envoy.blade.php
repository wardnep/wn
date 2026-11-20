@servers(['prod' => ['user01@athikit -p14321'], 'local' => '127.0.0.1'])

@setup
    $projectPath = getcwd();
@endsetup

@task('test', ['on' => 'local'])
    cd {{ $projectPath }}
    php artisan test
@endtask

@story('deploy')
    {{-- test --}}
    deploy-release
@endstory

@task('deploy-release', ['on' => 'prod'])
	cd /var/www/wn
	release=$(date +%Y%m%d%H%M%S)
	GIT_SSH_COMMAND="ssh -i ~/.ssh/id_ed25519_deploy -o StrictHostKeyChecking=no" \
	git clone git@github.com:wardnep/wn.git $release
	cd $release
	php8.3 "$(command -v composer)" install --quiet --no-interaction --prefer-dist
	ln -s ../env .env
	rm -rf storage
	ln -s ../storage storage
	php8.3 artisan migrate --no-interaction
	php8.3 artisan optimize
	php8.3 artisan config:clear
  	cd ..
	ln -sfn $release current
	find . -maxdepth 1 -name "2*" | sort | head -n -2 | xargs rm -Rf
@endtask
