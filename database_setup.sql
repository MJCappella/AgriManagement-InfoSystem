DROP DATABASE IF EXISTS amis_db;
CREATE DATABASE amis_db;
USE amis_db;

CREATE TABLE user_type_tbl (
    user_type_id INT AUTO_INCREMENT PRIMARY KEY,
    user_type ENUM('farmer', 'buyer', 'government', 'transporter', 'marketing', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);


CREATE TABLE admin (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    user_type_id INT,
    username VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    id_number INT(9) NOT NULL,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_type_id) REFERENCES user_type_tbl(user_type_id)
);

CREATE TABLE two_factor_auth (
    auth_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    user_type_id INT,
    code VARCHAR(6),
    status ENUM('pending', 'verified', 'expired', 'rejected') NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    verified_at TIMESTAMP,
    FOREIGN KEY (user_type_id) REFERENCES user_type_tbl(user_type_id)
);

CREATE TABLE farmer (
    farmer_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    location VARCHAR(100),
    phone VARCHAR(20),
    compliance_status ENUM('pending', 'approved', 'rejected') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE buyer (
    buyer_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE transporter (
    transport_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    phone VARCHAR(20),
    description TEXT,
    price DECIMAL(10, 2),
    availability ENUM('available', 'engaged', 'no_service') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE government (
    agency_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    location VARCHAR(100),
    phone VARCHAR(20),
    status ENUM('pending', 'approved', 'rejected') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE marketing (
    professional_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    company VARCHAR(100),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE crops (
    crop_id INT PRIMARY KEY AUTO_INCREMENT,
    cropname VARCHAR(100),
    description TEXT,
    price DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    farmer_id INT,
    buyer_id INT,
    crop_id INT,
    quantity INT,
    status ENUM('pending', 'confirmed', 'shipped', 'delivered') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT,
    FOREIGN KEY (farmer_id) REFERENCES farmer(farmer_id),
    FOREIGN KEY (buyer_id) REFERENCES buyer(buyer_id),
    FOREIGN KEY (crop_id) REFERENCES crops(crop_id)
);

CREATE TABLE compliance_certificates (
    certificate_id INT PRIMARY KEY AUTO_INCREMENT,
    farmer_id INT,
    status ENUM('pending', 'approved', 'rejected') NOT NULL,
    approved_by INT,
    FOREIGN KEY (farmer_id) REFERENCES farmer(farmer_id),
    FOREIGN KEY (approved_by) REFERENCES admin(admin_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE transactions (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    transaction_code VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved') NOT NULL,
    FOREIGN KEY (farmer_id) REFERENCES farmer(farmer_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE market_prices (
    price_id INT AUTO_INCREMENT PRIMARY KEY,
    crop_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    status ENUM('effective', 'not_effective', 'expired') NOT NULL,
    date DATE NOT NULL,
    FOREIGN KEY (crop_id) REFERENCES crops(crop_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE market_trends (
    trend_id INT AUTO_INCREMENT PRIMARY KEY,
    crop_id INT NOT NULL,
    trend_data TEXT,
    date DATE NOT NULL,
    FOREIGN KEY (crop_id) REFERENCES crops(crop_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE demand_trends (
    trend_id INT PRIMARY KEY AUTO_INCREMENT,
    crop_id INT,
    demand INT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT,
    FOREIGN KEY (crop_id) REFERENCES crops(crop_id)
);

CREATE TABLE yields (
    yield_id INT PRIMARY KEY AUTO_INCREMENT,
    farmer_id INT,
    crop_id INT,
    quantity INT,
    harvest_date DATE,
    transaction_code VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT,
    FOREIGN KEY (farmer_id) REFERENCES farmer(farmer_id),
    FOREIGN KEY (crop_id) REFERENCES crops(crop_id)
);

CREATE TABLE customer_feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    user_type_id INT NOT NULL,
    buyer_id INT NOT NULL,
    farmer_id INT NOT NULL,
    feedback TEXT,
    date DATE NOT NULL,
    FOREIGN KEY (user_type_id) REFERENCES user_type_tbl(user_type_id),
    FOREIGN KEY (buyer_id) REFERENCES buyer(buyer_id),
    FOREIGN KEY (farmer_id) REFERENCES farmer(farmer_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE forex (
    forex_id INT PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
    usd DECIMAL(10, 4),
    gbp DECIMAL(10, 4),
    eur DECIMAL(10, 4),
    cad DECIMAL(10, 4),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE counties (
    county_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    capital VARCHAR(100),
    code INT NOT NULL
);

CREATE TABLE sub_counties (
    sub_county_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    county_id INT NOT NULL,
    FOREIGN KEY (county_id) REFERENCES counties(county_id)
);



INSERT INTO user_type_tbl (user_type)
VALUES ('farmer'), ('buyer'), ('government'), ('transporter'), ('marketing'), ('admin');


INSERT INTO admin(user_type_id, username, email, id_number, password) VALUES(6,"John Smith","johnsmith@yahoo.com",23423231,"d0d8bda2ec288938dbed16522a638011"); 


INSERT INTO counties (name, code) VALUES ('Baringo', 30);
INSERT INTO counties (name, code) VALUES ('Bomet', 36);
INSERT INTO counties (name, code) VALUES ('Bungoma', 39);
INSERT INTO counties (name, code) VALUES ('Busia', 40);
INSERT INTO counties (name, code) VALUES ('Elgeyo-Marakwet', 28);
INSERT INTO counties (name, code) VALUES ('Embu', 14);
INSERT INTO counties (name, code) VALUES ('Garissa', 7);
INSERT INTO counties (name, code) VALUES ('Homa Bay', 43);
INSERT INTO counties (name, code) VALUES ('Isiolo', 11);
INSERT INTO counties (name, code) VALUES ('Kajiado', 34);
INSERT INTO counties (name, code) VALUES ('Kakamega', 37);
INSERT INTO counties (name, code) VALUES ('Kericho', 35);
INSERT INTO counties (name, code) VALUES ('Kiambu', 22);
INSERT INTO counties (name, code) VALUES ('Kilifi', 3);
INSERT INTO counties (name, code) VALUES ('Kirinyaga', 20);
INSERT INTO counties (name, code) VALUES ('Kisii', 45);
INSERT INTO counties (name, code) VALUES ('Kisumu', 42);
INSERT INTO counties (name, code) VALUES ('Kitui', 15);
INSERT INTO counties (name, code) VALUES ('Kwale', 2);
INSERT INTO counties (name, code) VALUES ('Laikipia', 31);
INSERT INTO counties (name, code) VALUES ('Lamu', 5);
INSERT INTO counties (name, code) VALUES ('Machakos', 16);
INSERT INTO counties (name, code) VALUES ('Makueni', 17);
INSERT INTO counties (name, code) VALUES ('Mandera', 9);
INSERT INTO counties (name, code) VALUES ('Marsabit', 10);
INSERT INTO counties (name, code) VALUES ('Meru', 12);
INSERT INTO counties (name, code) VALUES ('Migori', 44);
INSERT INTO counties (name, code) VALUES ('Mombasa', 1);
INSERT INTO counties (name, code) VALUES ("Murang'a", 21);
INSERT INTO counties (name, code) VALUES ('Nairobi', 47);
INSERT INTO counties (name, code) VALUES ('Nakuru', 32);
INSERT INTO counties (name, code) VALUES ('Nandi', 29);
INSERT INTO counties (name, code) VALUES ('Narok', 33);
INSERT INTO counties (name, code) VALUES ('Nyamira', 46);
INSERT INTO counties (name, code) VALUES ('Nyandarua', 18);
INSERT INTO counties (name, code) VALUES ('Nyeri', 19);
INSERT INTO counties (name, code) VALUES ('Samburu', 25);
INSERT INTO counties (name, code) VALUES ('Siaya', 41);
INSERT INTO counties (name, code) VALUES ('Taita-Taveta', 6);
INSERT INTO counties (name, code) VALUES ('Tana River', 4);
INSERT INTO counties (name, code) VALUES ('Tharaka-Nithi', 13);
INSERT INTO counties (name, code) VALUES ('Trans-Nzoia', 26);
INSERT INTO counties (name, code) VALUES ('Turkana', 23);
INSERT INTO counties (name, code) VALUES ('Uasin Gishu', 27);
INSERT INTO counties (name, code) VALUES ('Vihiga', 38);
INSERT INTO counties (name, code) VALUES ('Wajir', 8);
INSERT INTO counties (name, code) VALUES ('West Pokot', 24);


-- For Baringo (county_id = 30)
INSERT INTO sub_counties (name, county_id) VALUES ('Baringo central', 30);
INSERT INTO sub_counties (name, county_id) VALUES ('Baringo north', 30);
INSERT INTO sub_counties (name, county_id) VALUES ('Baringo south', 30);
INSERT INTO sub_counties (name, county_id) VALUES ('Eldama ravine', 30);
INSERT INTO sub_counties (name, county_id) VALUES ('Mogotio', 30);
INSERT INTO sub_counties (name, county_id) VALUES ('Tiaty', 30);

-- For Bomet (county_id = 36)
INSERT INTO sub_counties (name, county_id) VALUES ('Bomet central', 36);
INSERT INTO sub_counties (name, county_id) VALUES ('Bomet east', 36);
INSERT INTO sub_counties (name, county_id) VALUES ('Chepalungu', 36);
INSERT INTO sub_counties (name, county_id) VALUES ('Konoin', 36);
INSERT INTO sub_counties (name, county_id) VALUES ('Sotik', 36);

-- For Bungoma (county_id = 39)
INSERT INTO sub_counties (name, county_id) VALUES ('Bumula', 39);
INSERT INTO sub_counties (name, county_id) VALUES ('Kabuchai', 39);
INSERT INTO sub_counties (name, county_id) VALUES ('Kanduyi', 39);
INSERT INTO sub_counties (name, county_id) VALUES ('Kimilil', 39);
INSERT INTO sub_counties (name, county_id) VALUES ('Mt Elgon', 39);
INSERT INTO sub_counties (name, county_id) VALUES ('Sirisia', 39);
INSERT INTO sub_counties (name, county_id) VALUES ('Tongaren', 39);
INSERT INTO sub_counties (name, county_id) VALUES ('Webuye east', 39);
INSERT INTO sub_counties (name, county_id) VALUES ('Webuye west', 39);

-- For Busia (county_id = 40)
INSERT INTO sub_counties (name, county_id) VALUES ('Budalangi', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Butula', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Funyula', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Nambele', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Teso North', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Teso South', 40);

-- For Elgeyo-Marakwet (county_id = 28)
INSERT INTO sub_counties (name, county_id) VALUES ('Keiyo north', 28);
INSERT INTO sub_counties (name, county_id) VALUES ('Keiyo south', 28);
INSERT INTO sub_counties (name, county_id) VALUES ('Marakwet east', 28);
INSERT INTO sub_counties (name, county_id) VALUES ('Marakwet west', 28);

-- For Embu (county_id = 14)
INSERT INTO sub_counties (name, county_id) VALUES ('Manyatta', 14);
INSERT INTO sub_counties (name, county_id) VALUES ('Mbeere north', 14);
INSERT INTO sub_counties (name, county_id) VALUES ('Mbeere south', 14);
INSERT INTO sub_counties (name, county_id) VALUES ('Runyenjes', 14);

-- For Garissa (county_id = 7)
INSERT INTO sub_counties (name, county_id) VALUES ('Daadab', 7);
INSERT INTO sub_counties (name, county_id) VALUES ('Fafi', 7);
INSERT INTO sub_counties (name, county_id) VALUES ('Garissa', 7);
INSERT INTO sub_counties (name, county_id) VALUES ('Hulugho', 7);
INSERT INTO sub_counties (name, county_id) VALUES ('Ijara', 7);
INSERT INTO sub_counties (name, county_id) VALUES ('Lagdera balambala', 7);

-- For Homa Bay (county_id = 43)
INSERT INTO sub_counties (name, county_id) VALUES ('Homabay town', 43);
INSERT INTO sub_counties (name, county_id) VALUES ('Kabondo', 43);
INSERT INTO sub_counties (name, county_id) VALUES ('Karachwonyo', 43);
INSERT INTO sub_counties (name, county_id) VALUES ('Kasipul', 43);
INSERT INTO sub_counties (name, county_id) VALUES ('Mbita', 43);
INSERT INTO sub_counties (name, county_id) VALUES ('Ndhiwa', 43);
INSERT INTO sub_counties (name, county_id) VALUES ('Rangwe', 43);
INSERT INTO sub_counties (name, county_id) VALUES ('Suba', 43);

-- For Isiolo (county_id = 11)
INSERT INTO sub_counties (name, county_id) VALUES ('Central', 11);
INSERT INTO sub_counties (name, county_id) VALUES ('Garba tula', 11);
INSERT INTO sub_counties (name, county_id) VALUES ('Kina', 11);
INSERT INTO sub_counties (name, county_id) VALUES ('Merit', 11);
INSERT INTO sub_counties (name, county_id) VALUES ('Oldonyiro', 11);
INSERT INTO sub_counties (name, county_id) VALUES ('Sericho', 11);

-- For Kajiado (county_id = 34)
INSERT INTO sub_counties (name, county_id) VALUES ('Isinya', 34);
INSERT INTO sub_counties (name, county_id) VALUES ('Kajiado Central', 34);
INSERT INTO sub_counties (name, county_id) VALUES ('Kajiado North', 34);
INSERT INTO sub_counties (name, county_id) VALUES ('Loitokitok', 34);
INSERT INTO sub_counties (name, county_id) VALUES ('Mashuuru', 34);

-- For Kakamega (county_id = 37)
INSERT INTO sub_counties (name, county_id) VALUES ('Butere', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Kakamega central', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Kakamega east', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Kakamega north', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Kakamega south', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Khwisero', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Lugari', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Lukuyani', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Lurambi', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Matete', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Mumias', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Mutungu', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Navakholo', 37);

-- For Kericho (county_id = 35)
INSERT INTO sub_counties (name, county_id) VALUES ('Ainamoi', 35);
INSERT INTO sub_counties (name, county_id) VALUES ('Belgut', 35);
INSERT INTO sub_counties (name, county_id) VALUES ('Bureti', 35);
INSERT INTO sub_counties (name, county_id) VALUES ('Kipkelion east', 35);
INSERT INTO sub_counties (name, county_id) VALUES ('Kipkelion west', 35);
INSERT INTO sub_counties (name, county_id) VALUES ('Soin sigowet', 35);

-- For Kiambu (county_id = 22)
INSERT INTO sub_counties (name, county_id) VALUES ('Gatundu north', 22);
INSERT INTO sub_counties (name, county_id) VALUES ('Gatundu south', 22);
INSERT INTO sub_counties (name, county_id) VALUES ('Githunguri', 22);
INSERT INTO sub_counties (name, county_id) VALUES ('Juja', 22);
INSERT INTO sub_counties (name, county_id) VALUES ('Kabete', 22);
INSERT INTO sub_counties (name, county_id) VALUES ('Kiambaa', 22);
INSERT INTO sub_counties (name, county_id) VALUES ('Kiambu', 22);
INSERT INTO sub_counties (name, county_id) VALUES ('Kikuyu', 22);
INSERT INTO sub_counties (name, county_id) VALUES ('Limuru', 22);
INSERT INTO sub_counties (name, county_id) VALUES ('Ruiru', 22);
INSERT INTO sub_counties (name, county_id) VALUES ('Thika town', 22);
INSERT INTO sub_counties (name, county_id) VALUES ('Lari', 22);

-- For Kilifi (county_id = 3)
INSERT INTO sub_counties (name, county_id) VALUES ('Genzw', 3);
INSERT INTO sub_counties (name, county_id) VALUES ('Kaloleni', 3);
INSERT INTO sub_counties (name, county_id) VALUES ('Kilifi North', 3);
INSERT INTO sub_counties (name, county_id) VALUES ('Kilifi South', 3);
INSERT INTO sub_counties (name, county_id) VALUES ('Kilifi West', 3);
INSERT INTO sub_counties (name, county_id) VALUES ('Malindi', 3);
INSERT INTO sub_counties (name, county_id) VALUES ('Magarini', 3);
INSERT INTO sub_counties (name, county_id) VALUES ('Rabai', 3);

-- For Kirinyaga (county_id = 20)
INSERT INTO sub_counties (name, county_id) VALUES ('Gichugu', 20);
INSERT INTO sub_counties (name, county_id) VALUES ('Kirinyaga central', 20);
INSERT INTO sub_counties (name, county_id) VALUES ('Kirinyaga east', 20);
INSERT INTO sub_counties (name, county_id) VALUES ('Kirinyaga west', 20);
INSERT INTO sub_counties (name, county_id) VALUES ('Mwea', 20);

-- For Kisumu (county_id = 42)
INSERT INTO sub_counties (name, county_id) VALUES ('Kisumu central', 42);
INSERT INTO sub_counties (name, county_id) VALUES ('Kisumu east', 42);
INSERT INTO sub_counties (name, county_id) VALUES ('Kisumu west', 42);
INSERT INTO sub_counties (name, county_id) VALUES ('Mohoroni', 42);
INSERT INTO sub_counties (name, county_id) VALUES ('Nyakach', 42);
INSERT INTO sub_counties (name, county_id) VALUES ('Nyando', 42);
INSERT INTO sub_counties (name, county_id) VALUES ('Seme', 42);


-- For Kitui (county_id = 15)
INSERT INTO sub_counties (name, county_id) VALUES ('Kitui central', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitui east', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitui north', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitui south', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitui west', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Mwingi central', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Mwingi north', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Mwingi west', 15);

-- For Kwale (county_id = 2)
INSERT INTO sub_counties (name, county_id) VALUES ('Mutuga', 2);
INSERT INTO sub_counties (name, county_id) VALUES ('Kinango', 2);
INSERT INTO sub_counties (name, county_id) VALUES ('Kwale', 2);
INSERT INTO sub_counties (name, county_id) VALUES ('Lunga Lunga', 2);
INSERT INTO sub_counties (name, county_id) VALUES ('Msambweni', 2);

-- For Laikipia (county_id = 31)
INSERT INTO sub_counties (name, county_id) VALUES ('Laikipia central', 31);
INSERT INTO sub_counties (name, county_id) VALUES ('Laikipia east', 31);
INSERT INTO sub_counties (name, county_id) VALUES ('Laikipia north', 31);
INSERT INTO sub_counties (name, county_id) VALUES ('Laikipia west', 31);
INSERT INTO sub_counties (name, county_id) VALUES ('Nyahururu', 31);

-- For Lamu (county_id = 5)
INSERT INTO sub_counties (name, county_id) VALUES ('Lamu East', 5);
INSERT INTO sub_counties (name, county_id) VALUES ('Lamu West', 5);

-- For Machakos (county_id = 16)
INSERT INTO sub_counties (name, county_id) VALUES ('Kathiani', 16);
INSERT INTO sub_counties (name, county_id) VALUES ('Machakos town', 16);
INSERT INTO sub_counties (name, county_id) VALUES ('Masinga', 16);
INSERT INTO sub_counties (name, county_id) VALUES ('Matungulu', 16);
INSERT INTO sub_counties (name, county_id) VALUES ('Mavoko', 16);
INSERT INTO sub_counties (name, county_id) VALUES ('Mwala', 16);
INSERT INTO sub_counties (name, county_id) VALUES ('Yatta', 16);

-- For Makueni (county_id = 17)
INSERT INTO sub_counties (name, county_id) VALUES ('Kaiti', 17);
INSERT INTO sub_counties (name, county_id) VALUES ('Kibwei west', 17);
INSERT INTO sub_counties (name, county_id) VALUES ('Kibwezi east', 17);
INSERT INTO sub_counties (name, county_id) VALUES ('Kilome', 17);
INSERT INTO sub_counties (name, county_id) VALUES ('Makueni', 17);
INSERT INTO sub_counties (name, county_id) VALUES ('Mbooni', 17);

-- For Mandera (county_id = 6)
INSERT INTO sub_counties (name, county_id) VALUES ('Mandera central', 6);
INSERT INTO sub_counties (name, county_id) VALUES ('Mandera east', 6);
INSERT INTO sub_counties (name, county_id) VALUES ('Mandera north', 6);
INSERT INTO sub_counties (name, county_id) VALUES ('Mandera south', 6);
INSERT INTO sub_counties (name, county_id) VALUES ('Mandera west', 6);

-- For Marsabit (county_id = 10)
INSERT INTO sub_counties (name, county_id) VALUES ('Laisamis', 10);
INSERT INTO sub_counties (name, county_id) VALUES ('Moyale', 10);
INSERT INTO sub_counties (name, county_id) VALUES ('North Hor', 10);
INSERT INTO sub_counties (name, county_id) VALUES ('Saku', 10);

-- For Meru (county_id = 15)
INSERT INTO sub_counties (name, county_id) VALUES ('Buuri', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Imenti central', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Imenti north', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Imenti south', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Meru', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Tigania east', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Tigania west', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Tharaka', 15);

-- For Migori (county_id = 44)
INSERT INTO sub_counties (name, county_id) VALUES ('Awendo', 44);
INSERT INTO sub_counties (name, county_id) VALUES ('Kuria east', 44);
INSERT INTO sub_counties (name, county_id) VALUES ('Kuria west', 44);
INSERT INTO sub_counties (name, county_id) VALUES ('Mabera', 44);
INSERT INTO sub_counties (name, county_id) VALUES ('Ntimaru', 44);
INSERT INTO sub_counties (name, county_id) VALUES ('Rongo', 44);
INSERT INTO sub_counties (name, county_id) VALUES ('Suna east', 44);
INSERT INTO sub_counties (name, county_id) VALUES ('Suna west', 44);
INSERT INTO sub_counties (name, county_id) VALUES ('Uriri', 44);

-- For Muranga (county_id = 21)
INSERT INTO sub_counties (name, county_id) VALUES ('Gatanga', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Kahuro', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Kandara', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Kangema', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Kigumo', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Kiharu', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Mathioya', 21);
INSERT INTO sub_counties (name, county_id) VALUES ("Murang'a south", 21);


-- For Migori (county_id = 42)
INSERT INTO sub_counties (name, county_id) VALUES ('Awendo', 42);
INSERT INTO sub_counties (name, county_id) VALUES ('Rongo', 42);
INSERT INTO sub_counties (name, county_id) VALUES ('Suna east', 42);
INSERT INTO sub_counties (name, county_id) VALUES ('Suna west', 42);
INSERT INTO sub_counties (name, county_id) VALUES ('Uriri', 42);

-- For Mombasa (county_id = 1)
INSERT INTO sub_counties (name, county_id) VALUES ('Changamwe', 1);
INSERT INTO sub_counties (name, county_id) VALUES ('Jomvu', 1);
INSERT INTO sub_counties (name, county_id) VALUES ('Kisauni', 1);
INSERT INTO sub_counties (name, county_id) VALUES ('Mvita', 1);
INSERT INTO sub_counties (name, county_id) VALUES ('Nyali', 1);

-- For Nairobi (county_id = 47)
INSERT INTO sub_counties (name, county_id) VALUES ('Dagoretti North Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Dagoretti South Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Embakasi Central Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Embakasi East Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Embakasi North Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Embakasi South Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Embakasi West Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Kamukunji Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Kasarani Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Kibra Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ("Lang'ata Sub County", 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Makadara Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Mathare Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Roysambu Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Ruaraka Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Starehe Sub County', 47);
INSERT INTO sub_counties (name, county_id) VALUES ('Westlands Sub County', 47);


-- For Nakuru (county_id = 32)
INSERT INTO sub_counties (name, county_id) VALUES ('Bahati', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Gilgil', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Kuresoi north', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Kuresoi south', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Molo', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Naivasha', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Nakuru town east', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Nakuru town west', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Njoro', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Rongai', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Subukia', 32);


-- For Nandi (county_id = 29)
INSERT INTO sub_counties (name, county_id) VALUES ('Aldai', 29);
INSERT INTO sub_counties (name, county_id) VALUES ('Chesumei', 29);
INSERT INTO sub_counties (name, county_id) VALUES ('Emgwen', 29);
INSERT INTO sub_counties (name, county_id) VALUES ('Mosop', 29);
INSERT INTO sub_counties (name, county_id) VALUES ('Namdi hills', 29);
INSERT INTO sub_counties (name, county_id) VALUES ('Tindiret', 29);


-- For Narok (county_id = 33)
INSERT INTO sub_counties (name, county_id) VALUES ('Narok east', 33);
INSERT INTO sub_counties (name, county_id) VALUES ('Narok north', 33);
INSERT INTO sub_counties (name, county_id) VALUES ('Narok south', 33);
INSERT INTO sub_counties (name, county_id) VALUES ('Narok west', 33);
INSERT INTO sub_counties (name, county_id) VALUES ('Transmara east', 33);
INSERT INTO sub_counties (name, county_id) VALUES ('Transmara west', 33);


-- For Nyamira (county_id = 46)
INSERT INTO sub_counties (name, county_id) VALUES ('Borabu', 46);
INSERT INTO sub_counties (name, county_id) VALUES ('Manga', 46);
INSERT INTO sub_counties (name, county_id) VALUES ('Masaba north', 46);
INSERT INTO sub_counties (name, county_id) VALUES ('Nyamira north', 46);
INSERT INTO sub_counties (name, county_id) VALUES ('Nyamira south', 46);


-- For Nyandarua (county_id = 18)
INSERT INTO sub_counties (name, county_id) VALUES ('Kinangop', 18);
INSERT INTO sub_counties (name, county_id) VALUES ('Kipipiri', 18);
INSERT INTO sub_counties (name, county_id) VALUES ('Ndaragwa', 18);
INSERT INTO sub_counties (name, county_id) VALUES ('Ol Kalou', 18);
INSERT INTO sub_counties (name, county_id) VALUES ('Ol joro orok', 18);


-- For Nyeri (county_id = 19)
INSERT INTO sub_counties (name, county_id) VALUES ('Kieni east', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Kieni west', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Mathira east', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Mathira west', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Mkurweni', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Nyeri town', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Othaya', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Tetu', 19);


-- For Siaya (county_id = 41)
INSERT INTO sub_counties (name, county_id) VALUES ('Alego usonga', 41);
INSERT INTO sub_counties (name, county_id) VALUES ('Bondo', 41);
INSERT INTO sub_counties (name, county_id) VALUES ('Gem', 41);
INSERT INTO sub_counties (name, county_id) VALUES ('Rarieda', 41);
INSERT INTO sub_counties (name, county_id) VALUES ('Ugenya', 41);
INSERT INTO sub_counties (name, county_id) VALUES ('Unguja', 41);


-- For Samburu (county_id = 25)
INSERT INTO sub_counties (name, county_id) VALUES ('Samburu east', 25);
INSERT INTO sub_counties (name, county_id) VALUES ('Samburu north', 25);
INSERT INTO sub_counties (name, county_id) VALUES ('Samburu west', 25);


-- For Taita-Taveta (county_id = 29)
INSERT INTO sub_counties (name, county_id) VALUES ('Mwatate', 6);
INSERT INTO sub_counties (name, county_id) VALUES ('Taveta', 6);
INSERT INTO sub_counties (name, county_id) VALUES ('Voi', 6);
INSERT INTO sub_counties (name, county_id) VALUES ('Wundanyi', 6);

-- Insert Sub-Counties for Tana River
INSERT INTO sub_counties (name, county_id) VALUES ('Bura', 4);
INSERT INTO sub_counties (name, county_id) VALUES ('Galole', 4);
INSERT INTO sub_counties (name, county_id) VALUES ('Garsen', 4);

-- Insert Sub-Counties for Tharaka-Nithi
INSERT INTO sub_counties (name, county_id) VALUES ('Chuka', 13);
INSERT INTO sub_counties (name, county_id) VALUES ('Igambangobe', 13);
INSERT INTO sub_counties (name, county_id) VALUES ('Maara', 13);
INSERT INTO sub_counties (name, county_id) VALUES ('Muthambi', 13);
INSERT INTO sub_counties (name, county_id) VALUES ('Tharaka north', 13);
INSERT INTO sub_counties (name, county_id) VALUES ('Tharaka south', 13);

-- Insert Sub-Counties for Trans-Nzoia
INSERT INTO sub_counties (name, county_id) VALUES ('Cherangany', 26);
INSERT INTO sub_counties (name, county_id) VALUES ('Endebess', 26);
INSERT INTO sub_counties (name, county_id) VALUES ('Kiminini', 26);
INSERT INTO sub_counties (name, county_id) VALUES ('Kwanza', 26);
INSERT INTO sub_counties (name, county_id) VALUES ('Saboti', 26);

-- Insert Sub-Counties for Turkana
INSERT INTO sub_counties (name, county_id) VALUES ('Loima', 23);
INSERT INTO sub_counties (name, county_id) VALUES ('Turkana central', 23);
INSERT INTO sub_counties (name, county_id) VALUES ('Turkana east', 23);
INSERT INTO sub_counties (name, county_id) VALUES ('Turkana north', 23);
INSERT INTO sub_counties (name, county_id) VALUES ('Turkana south', 23);

-- Insert Sub-Counties for Uasin Gishu
INSERT INTO sub_counties (name, county_id) VALUES ('Ainabkoi', 27);
INSERT INTO sub_counties (name, county_id) VALUES ('Kapseret', 27);
INSERT INTO sub_counties (name, county_id) VALUES ('Kesses', 27);
INSERT INTO sub_counties (name, county_id) VALUES ('Moiben', 27);
INSERT INTO sub_counties (name, county_id) VALUES ('Soy', 27);
INSERT INTO sub_counties (name, county_id) VALUES ('Turbo', 27);

-- Insert Sub-Counties for Vihiga
INSERT INTO sub_counties (name, county_id) VALUES ('Emuhaya', 38);
INSERT INTO sub_counties (name, county_id) VALUES ('Hamisi', 38);
INSERT INTO sub_counties (name, county_id) VALUES ('Luanda', 38);
INSERT INTO sub_counties (name, county_id) VALUES ('Sabatia', 38);
INSERT INTO sub_counties (name, county_id) VALUES ('Vihiga', 38);

-- Insert Sub-Counties for Wajir
INSERT INTO sub_counties (name, county_id) VALUES ('Eldas', 8);
INSERT INTO sub_counties (name, county_id) VALUES ('Tarbaj', 8);
INSERT INTO sub_counties (name, county_id) VALUES ('Wajir East', 8);
INSERT INTO sub_counties (name, county_id) VALUES ('Wajir North', 8);
INSERT INTO sub_counties (name, county_id) VALUES ('Wajir South', 8);
INSERT INTO sub_counties (name, county_id) VALUES ('Wajir West', 8);

-- Insert Sub-Counties for West Pokot
INSERT INTO sub_counties (name, county_id) VALUES ('Central Pokot', 24);
INSERT INTO sub_counties (name, county_id) VALUES ('North Pokot', 24);
INSERT INTO sub_counties (name, county_id) VALUES ('Pokot South', 24);
INSERT INTO sub_counties (name, county_id) VALUES ('West Pokot', 24);


-- For Kericho (county_id = 29)
INSERT INTO sub_counties (name, county_id) VALUES ('Ainabkoi', 29);
INSERT INTO sub_counties (name, county_id) VALUES ('Bureti', 29);
INSERT INTO sub_counties (name, county_id) VALUES ('Kipkelion East', 29);
INSERT INTO sub_counties (name, county_id) VALUES ('Kipkelion West', 29);
INSERT INTO sub_counties (name, county_id) VALUES ('Kericho', 29);
INSERT INTO sub_counties (name, county_id) VALUES ('Litein', 29);

-- For Keruguya (county_id = 12)
INSERT INTO sub_counties (name, county_id) VALUES ('Gichugu', 12);
INSERT INTO sub_counties (name, county_id) VALUES ('Kirinyaga central', 12);
INSERT INTO sub_counties (name, county_id) VALUES ('Kirinyaga east', 12);
INSERT INTO sub_counties (name, county_id) VALUES ('Kirinyaga west', 12);
INSERT INTO sub_counties (name, county_id) VALUES ('Mwea', 12);

-- For Kisii (county_id = 45)
INSERT INTO sub_counties (name, county_id) VALUES ('Bomachoge', 45);
INSERT INTO sub_counties (name, county_id) VALUES ('Bomachoge Borabu', 45);
INSERT INTO sub_counties (name, county_id) VALUES ('South Mugirango', 45);
INSERT INTO sub_counties (name, county_id) VALUES ('Bobasi', 45);
INSERT INTO sub_counties (name, county_id) VALUES ('Nyaribari Chache', 45);
INSERT INTO sub_counties (name, county_id) VALUES ('Nyaribari Masaba', 45);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitutu Chache', 45);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitutu Chache North', 45);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitutu Chache South', 45);

-- For Kitale (county_id = 11)
INSERT INTO sub_counties (name, county_id) VALUES ('Endebess', 11);
INSERT INTO sub_counties (name, county_id) VALUES ('Kiminini', 11);
INSERT INTO sub_counties (name, county_id) VALUES ('Mt Elgon', 11);
INSERT INTO sub_counties (name, county_id) VALUES ('Saboti', 11);
INSERT INTO sub_counties (name, county_id) VALUES ('Trans Nzoia East', 11);
INSERT INTO sub_counties (name, county_id) VALUES ('Trans Nzoia West', 11);

-- For Vihiga (county_id = 23)
INSERT INTO sub_counties (name, county_id) VALUES ('Emuhaya', 23);
INSERT INTO sub_counties (name, county_id) VALUES ('Hamisi', 23);
INSERT INTO sub_counties (name, county_id) VALUES ('Sabatia', 23);
INSERT INTO sub_counties (name, county_id) VALUES ('Vihiga', 23);

-- For Bungoma (county_id = 9)
INSERT INTO sub_counties (name, county_id) VALUES ('Bumula', 9);
INSERT INTO sub_counties (name, county_id) VALUES ('Chwele', 9);
INSERT INTO sub_counties (name, county_id) VALUES ('Kabuchai', 9);
INSERT INTO sub_counties (name, county_id) VALUES ('Kanduyi', 9);
INSERT INTO sub_counties (name, county_id) VALUES ('Mt Elgon', 9);
INSERT INTO sub_counties (name, county_id) VALUES ('Sirisia', 9);
INSERT INTO sub_counties (name, county_id) VALUES ('Tongaren', 9);

-- For Bomet (county_id = 24)
INSERT INTO sub_counties (name, county_id) VALUES ('Bomet Central', 24);
INSERT INTO sub_counties (name, county_id) VALUES ('Bomet East', 24);
INSERT INTO sub_counties (name, county_id) VALUES ('Bomet West', 24);
INSERT INTO sub_counties (name, county_id) VALUES ('Chepalungu', 24);
INSERT INTO sub_counties (name, county_id) VALUES ('Konoin', 24);
INSERT INTO sub_counties (name, county_id) VALUES ('Siongiroi', 24);
