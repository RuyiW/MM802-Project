-- ===========================================================
-- This is the table file that creates tables in database.
-- It needs to be called when initiallizing the database.
-- ===========================================================

-- following two tables are the two main tables in our database
-- request table stores all the request data

CREATE TABLE IF NOT EXISTS 311_Explorer (
	ticket_number bigint(10) UNSIGNED PRIMARY KEY, 
	date_created VARCHAR(20),
	date_closed VARCHAR(20),
	311_request_status VARCHAR(5) NOT NULL,
	311_status_detail VARCHAR(20),
	service_category VARCHAR(20),
	service_details VARCHAR(30),
	business_unit VARCHAR(50),
	311_neighbourhood VARCHAR(40),
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
	-- complaints table stores all the complaint data
CREATE TABLE IF NOT EXISTS Bylaw (
	complaint_number INT(3),
	bylaw_year YEAR(4),
	month_number INT(2),
	month VARCHAR(10),
	report_period VARCHAR(15),
	bylaw_neighbourhood VARCHAR(40),
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

-- following 4 tables are used for store selection records for requests filter section
CREATE TABLE IF NOT EXISTS 311_ward (
	ticket_number bigint(10), 
	date_created VARCHAR(20),
	date_closed VARCHAR(20),
	311_request_status VARCHAR(5) NOT NULL,
	311_status_detail VARCHAR(20),
	service_category VARCHAR(20),
	service_details VARCHAR(30),
	business_unit VARCHAR(50),
	311_neighbourhood VARCHAR(40),
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

CREATE TABLE IF NOT EXISTS 311_neighbourhood (
	ticket_number bigint(10), 
	date_created VARCHAR(20),
	date_closed VARCHAR(20),
	311_request_status VARCHAR(5) NOT NULL,
	311_status_detail VARCHAR(20),
	service_category VARCHAR(20),
	service_details VARCHAR(30),
	business_unit VARCHAR(50),
	311_neighbourhood VARCHAR(40),
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
CREATE TABLE IF NOT EXISTS service_category (
	ticket_number bigint(10), 
	date_created VARCHAR(20),
	date_closed VARCHAR(20),
	311_request_status VARCHAR(5) NOT NULL,
	311_status_detail VARCHAR(20),
	service_category VARCHAR(20),
	service_details VARCHAR(30),
	business_unit VARCHAR(50),
	311_neighbourhood VARCHAR(40),
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

CREATE TABLE IF NOT EXISTS 311_request_status (
	ticket_number bigint(10), 
	date_created VARCHAR(20),
	date_closed VARCHAR(20),
	311_request_status VARCHAR(5) NOT NULL,
	311_status_detail VARCHAR(20),
	service_category VARCHAR(20),
	service_details VARCHAR(30),
	business_unit VARCHAR(50),
	311_neighbourhood VARCHAR(40),
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

-- temp table for storing filter selection temporary
CREATE TABLE IF NOT EXISTS temp_311(
	ticket_number bigint(10), 
	date_created VARCHAR(20),
	date_closed VARCHAR(20),
	311_request_status VARCHAR(5) NOT NULL,
	311_status_detail VARCHAR(20),
	service_category VARCHAR(20),
	service_details VARCHAR(30),
	business_unit VARCHAR(50),
	311_neighbourhood VARCHAR(40),
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

-- 2 result tables for storing selected result of filter
CREATE TABLE IF NOT EXISTS checked_311_result (
	ticket_number bigint(10), 
	date_created VARCHAR(20),
	date_closed VARCHAR(20),
	311_request_status VARCHAR(5) NOT NULL,
	311_status_detail VARCHAR(20),
	service_category VARCHAR(20),
	service_details VARCHAR(30),
	business_unit VARCHAR(50),
	311_neighbourhood VARCHAR(40),
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

CREATE TABLE IF NOT EXISTS submitted_checked_311 (
	ticket_number bigint(10), 
	date_created VARCHAR(20),
	date_closed VARCHAR(20),
	311_request_status VARCHAR(5) NOT NULL,
	311_status_detail VARCHAR(20),
	service_category VARCHAR(20),
	service_details VARCHAR(30),
	business_unit VARCHAR(50),
	311_neighbourhood VARCHAR(40),
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

-- following 4 tables are used for store selection records for complaints filter section
CREATE TABLE IF NOT EXISTS month (
	complaint_number INT(3),
	bylaw_year YEAR(4),
	month_number INT(2),
	month VARCHAR(10),
	report_period VARCHAR(15),
	bylaw_neighbourhood VARCHAR(40),
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

CREATE TABLE IF NOT EXISTS bylaw_year (
	complaint_number INT(3),
	bylaw_year YEAR(4),
	month_number INT(2),
	month VARCHAR(10),
	report_period VARCHAR(15),
	bylaw_neighbourhood VARCHAR(40),
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

CREATE TABLE IF NOT EXISTS complaint (
	complaint_number INT(3),
	bylaw_year YEAR(4),
	month_number INT(2),
	month VARCHAR(10),
	report_period VARCHAR(15),
	bylaw_neighbourhood VARCHAR(40),
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

CREATE TABLE IF NOT EXISTS bylaw_status (
	complaint_number INT(3),
	bylaw_year YEAR(4),
	month_number INT(2),
	month VARCHAR(10),
	report_period VARCHAR(15),
	bylaw_neighbourhood VARCHAR(40),
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
-- temp table for storing filter selection temporary
CREATE TABLE IF NOT EXISTS temp_bylaw (
	complaint_number INT(3),
	bylaw_year YEAR(4),
	month_number INT(2),
	month VARCHAR(10),
	report_period VARCHAR(15),
	bylaw_neighbourhood VARCHAR(40),
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
-- 2 result tables for storing selected result of filter
CREATE TABLE IF NOT EXISTS checked_bylaw_result (
	complaint_number INT(3),
	bylaw_year YEAR(4),
	month_number INT(2),
	month VARCHAR(10),
	report_period VARCHAR(15),
	bylaw_neighbourhood VARCHAR(40),
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

CREATE TABLE IF NOT EXISTS submitted_checked_bylaw (
	complaint_number INT(3),
	bylaw_year YEAR(4),
	month_number INT(2),
	month VARCHAR(10),
	report_period VARCHAR(15),
	bylaw_neighbourhood VARCHAR(40),
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


-- following 3 tables are used for storing k nearest neighbour results
CREATE TABLE IF NOT EXISTS match_resultdays (
	complaint_number INT(3),
	matched_ticket_number bigint(10),
	service_category VARCHAR(20),
	311_latitude FLOAT(20, 15),
	311_longtitude FLOAT(20, 15)
);


CREATE TABLE IF NOT EXISTS match_resultdistance (
	complaint_number INT(3),
	matched_ticket_number bigint(10),
	service_category VARCHAR(20),
	311_latitude FLOAT(20, 15),
	311_longtitude FLOAT(20, 15),
	distkm FLOAT(5, 3)
);

CREATE TABLE IF NOT EXISTS match_resultNeighbourhood (
	complaint_number INT(3),
	matched_ticket_number bigint(10),
	service_category VARCHAR(20),
	311_latitude FLOAT(20, 15),
	311_longtitude FLOAT(20, 15)
);