# Cibonfire installation (0.8.3)
Codeigniter based framework for new website, to make improvement, standard and supporting new technology.
	
## Additional library

## Installation config
    Remove "..\Bonfire\application\config\installed.txt" for new installation

	
## How to remove "index.php" also "public" folder
	Step 1: Goto ci-bonfire/application/config/config.php, remove "index.php" from index-page config.
		    $config['index_page'] = "";
		
	Step 2: Change 1.htaccess in ci-bonfire/public/ to .htaccess update line #158, change to your subdirectory name
			<IfModule mod_rewrite.c>
			  Options +FollowSymlinks
			  RewriteEngine On
			  RewriteBase /ci-bonfire
			  RewriteCond %{REQUEST_URI} ^bonfire/codeigniter.*
			  RewriteRule ^(.*)$ /index.php?/$1 [L]
			</IfModule>
			
			and further down to line #182, prepend "public" to "index.php"
			
			<IfModule mod_rewrite.c>
			  RewriteCond %{REQUEST_FILENAME} !-f
			  RewriteCond %{REQUEST_FILENAME} !-d
			  RewriteRule ^(.*)$ index.php/$1 [L]
			</IfModule>
			
	Step 3: Rename (for backup purpose) or remove index.php and .htaccess in your subdirectory, ci-bonfire
	
	Step 4: Then refer to "Reverting To Traditional Structure" in this cibonfire's documentation. Move all files from public folder up 1 level to your subdirectory.
	
	Step 5: Update index.php as the following
			$path = ".";

## SQL Server Connection
    http://robsphp.blogspot.com/2012/09/how-to-install-microsofts-sql-server.html

		
## The Team
	The team is made up from ICT PSI member, started from 2019.
		[madevanni](https://github.com/madevanni) - Lead Developer