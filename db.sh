	echo "Please enter your MySQL user and password!";
	echo "User:";
	read user;
	echo "Password";
	read passwd;
	dbname=$1;
	username=$1;
	charset="utf8";
	userpass="db-${1}";

	echo "Creating new  database..."
        mysql -u${user} -p${passwd} -e "CREATE DATABASE ${dbname};"
#	mysql -u${user} -p${passwd} -e "CREATE DATABASE ${dbname} /*\!40100 DEFAULT CHARACTER SET ${charset} */;"
	echo "Database successfully created!"
	echo "Showing existing databases..."
	mysql -u${user} -p${passwd} -e "show databases;"
	echo "Creating new user..."
	mysql -u${user} -p${passwd} -e "CREATE USER ${username}@localhost IDENTIFIED BY '${userpass}';"
	echo "User successfully created!"
	echo ""
	echo "Granting ALL privileges on ${dbname} to ${username}!"
	mysql -u${user} -p${passwd} -e "GRANT ALL PRIVILEGES ON ${dbname}.* TO '${username}'@'localhost';"
	mysql -u${user} -p${passwd} -e "FLUSH PRIVILEGES;"
	echo "DATABASE CREATED"
	exit
