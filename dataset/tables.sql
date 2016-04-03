CREATE TABLE IF NOT EXISTS 311_Explorer (
	ticket_number bigint(10) UNSIGNED PRIMARY KEY, 
	date_created TIMESTAMP,
	date_closed TIMESTAMP,
	request_status VARCHAR(5) NOT NULL,
	status_detail VARCHAR(20),
	service_category VARCHAR(20),
	service_details VARCHAR(30),
	business_unit VARCHAR(50),
	neighbourhood VARCHAR(20),
	community_league VARCHAR(60),
	ward VARCHAR(7),
	address VARCHAR(60),
	latitude FLOAT(20, 15),
	longtitude FLOAT(20, 15),
	location_x FLOAT(20, 15),
	location_y FLOAT(20, 15),
	ticket_source VARCHAR(15),
	calendar_year YEAR(4),
	count INT(1),
	posse_number VARCHAR(13),
	transit_ref_number INT(10)
);

CREATE TABLE IF NOT EXISTS Bylaw (
	year YEAR(4),
	month_number INT(2),
	month VARCHAR(10),
	report_period VARCHAR(15),
	neighbourhood VARCHAR(20),
	neighbourhood_id INT(4),
	complaint VARCHAR(20) NOT NULL,
	initiated_by VARCHAR(15),
	status VARCHAR(20),
	count INT(3),
	latitude FLOAT(20, 15),
	longtitude FLOAT(20, 15),
	location_x FLOAT(20, 15),
	location_y FLOAT(20, 15)
);

CREATE TABLE IF NOT EXISTS Neighbourhood_Centroid (
	neighbourhood_id INT(4),
	neighbourhood VARCHAR(20),
	latitude FLOAT(20, 15),
	longtitude FLOAT(20, 15),
	location_x FLOAT(20, 15),
	location_y FLOAT(20, 15)
);

CREATE TABLE IF NOT EXISTS Ward_Boundaries (
	ward VARCHAR(7),
	area_km2 FLOAT(20, 15)
);

CREATE TABLE IF NOT EXISTS Neighbourhood_Boundaries (
	neighbourhood VARCHAR(20),
	neighbourhood_id INT(4),
	area_km2 FLOAT(20, 15)
);
