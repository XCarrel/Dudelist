
#Pre-requisites

- node.js installed (npm command available)
- Workbench v6 or more
- phpStorm 2017 or more
- LAMP server is running
- Apache Rewrite module is enabled

#Installation

1. Clone repo on your local drive
1. `cd` into Dudelist directory
1. run `npm install`
1. If necessary, setup a connection to your database server in Workbench
1. Synchronize your database server with the model `data/dudes.mwb`
1. Open phpStorm, open the Dudelist projet
1. If necessary, setup a deployment connection to your LAMP server
1. Upload the project to your LAMP server
1. If necessary, setup a MySQL datasource to the database `dudes` in phpStorm
1. Open an SQL console on your datasource
1. Execute the script `data/data.sql`
