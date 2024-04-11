# config valid for current version and patch releases of Capistrano
lock "~> 3.14.0"

set :application, "tafiopro"
set :repo_url, "git@bitbucket.org:tafio/tafiopro.git"

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
# set :deploy_to, "/var/www/my_app_name"

# Default value for :format is :airbrussh.
# set :format, :airbrussh

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
# set :format_options, command_output: true, log_file: "log/capistrano.log", color: :auto, truncate: :auto

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# append :linked_files, "config/database.yml"

# Default value for linked_dirs is []
# append :linked_dirs, "log", "tmp/pids", "tmp/cache", "tmp/sockets", "public/system"

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for local_user is ENV['USER']
# set :local_user, -> { `git config user.name`.chomp }

# Default value for keep_releases is 5
 set :keep_releases, 5

# Uncomment the following to require manually verifying the host key before first deploy.
 set :ssh_options, {
	keys: %w(~/.ssh/bitbucket)
	} 

namespace :deploy do
	desc "Build"
	after :updated, :build do
		on roles(:app) do
			within release_path do
				execute :cp, "#{shared_path}/.env ./"
				#execute :composer, "install --no-scripts --quiet --optimize-autoloader"
				execute :composer, "install --no-dev --ignore-platform-reqs --no-scripts --quiet --optimize-autoloader"
				execute :chmod, "u+x artisan" #make artisan executable
				execute :php, "artisan migrate" #run db migrations
				execute :mysql, "--login-path=staging teguh_tafiopro < database_dump/coredb.sql" #restore core tables content
				execute :sudo, "chown -R www-data:www-data ./" #change owner to www-data
			end
		end
	end

	desc "Restart"
		task :restart do
			on roles(:app) do
				within release_path do
					execute :chmod, "-R 777 storage/cache"
					execute :chmod, "-R 777 storage/logs"
					execute :chmod, "-R 777 storage/meta"
					execute :chmod, "-R 777 storage/sessions"
					execute :chmod, "-R 777 storage/views"
				end
			end
		end
	
end
