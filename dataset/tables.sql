CREATE TABLE IF NOT EXISTS 311_Explorer (
	ticket_number bigint(10) UNSIGNED PRIMARY KEY, 
	date_created TIMESTAMP,
	date_closed TIMESTAMP,
	311_request_status VARCHAR(5) NOT NULL,
	311_status_detail VARCHAR(20),
	service_category VARCHAR(20),
	service_details VARCHAR(30),
	business_unit VARCHAR(50),
	311_neighbourhood VARCHAR(20),
	community_league VARCHAR(60),
	311_ward VARCHAR(7),
	address VARCHAR(60),
	311_latitude FLOAT(20, 15),
	311_longtitude FLOAT(20, 15),
	311_location_x FLOAT(20, 15),
	311_location_y FLOAT(20, 15),
	ticket_source VARCHAR(15),
	calendar_year YEAR(4),
	311_count INT(1),
	posse_number VARCHAR(13),
	transit_ref_number INT(10)
);

CREATE TABLE IF NOT EXISTS Bylaw (
	bylaw_year YEAR(4),
	month_number INT(2),
	month VARCHAR(10),
	report_period VARCHAR(15),
	bylaw_neighbourhood VARCHAR(20),
	bylaw_neighbourhood_id INT(4),
	complaint VARCHAR(20) NOT NULL,
	initiated_by VARCHAR(15),
	bylaw_status VARCHAR(20),
	bylaw_count INT(3),
	bylaw_latitude FLOAT(20, 15),
	bylaw_longtitude FLOAT(20, 15),
	bylaw_location_x FLOAT(20, 15),
	bylaw_location_y FLOAT(20, 15)
);

-- CREATE TABLE IF NOT EXISTS Neighbourhood_Centroid (
-- 	neighbourhood_id INT(4),
-- 	neighbourhood VARCHAR(20),
-- 	latitude FLOAT(20, 15),
-- 	longtitude FLOAT(20, 15),
-- 	location_x FLOAT(20, 15),
-- 	location_y FLOAT(20, 15)
-- );

-- CREATE TABLE IF NOT EXISTS Ward_Boundaries (
-- 	ward VARCHAR(7),
-- 	area_km2 FLOAT(20, 15)
-- );

-- CREATE TABLE IF NOT EXISTS Neighbourhood_Boundaries (
-- 	neighbourhood VARCHAR(20),
-- 	neighbourhood_id INT(4),
-- 	area_km2 FLOAT(20, 15)
-- );

CREATE TABLE IF NOT EXISTS checked_result (
	ticket_number bigint(10), 
	date_created TIMESTAMP,
	date_closed TIMESTAMP,
	311_request_status VARCHAR(5) NOT NULL,
	311_status_detail VARCHAR(20),
	service_category VARCHAR(20),
	service_details VARCHAR(30),
	business_unit VARCHAR(50),
	311_neighbourhood VARCHAR(20),
	community_league VARCHAR(60),
	311_ward VARCHAR(7),
	address VARCHAR(60),
	311_latitude FLOAT(20, 15),
	311_longtitude FLOAT(20, 15),
	311_location_x FLOAT(20, 15),
	311_location_y FLOAT(20, 15),
	ticket_source VARCHAR(15),
	calendar_year YEAR(4),
	311_count INT(1),
	posse_number VARCHAR(13),
	transit_ref_number INT(10),
	bylaw_year YEAR(4),
	month_number INT(2),
	month VARCHAR(10),
	report_period VARCHAR(15),
	bylaw_neighbourhood VARCHAR(20),
	bylaw_neighbourhood_id INT(4),
	complaint VARCHAR(20) NOT NULL,
	initiated_by VARCHAR(15),
	bylaw_status VARCHAR(20),
	bylaw_count INT(3),
	bylaw_latitude FLOAT(20, 15),
	bylaw_longtitude FLOAT(20, 15),
	bylaw_location_x FLOAT(20, 15),
	bylaw_location_y FLOAT(20, 15)
);