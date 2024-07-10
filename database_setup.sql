CREATE DATABASE amis_db;
USE amis_db;

CREATE TABLE user_type (
    user_type_id INT AUTO_INCREMENT PRIMARY KEY,
    user_type ENUM('farmer', 'buyer', 'government', 'transporter', 'marketing', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE admins (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    id_number INT(9) NOT NULL,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE two_factor_auth (
    auth_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    user_type_id INT,
    code VARCHAR(6),
    status ENUM('pending', 'verified', 'expired', 'rejected') NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    verified_at TIMESTAMP,
    FOREIGN KEY (user_type_id) REFERENCES user_type(user_type_id)
);

CREATE TABLE farmer (
    farmer_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
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
    name VARCHAR(100),
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
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    description TEXT,
    price DECIMAL(10, 2),
    availability ENUM('available', 'engaged', 'no_service') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE government_agency (
    agency_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    location VARCHAR(100),
    phone VARCHAR(20),
    nrb_info VARCHAR(255), -- National Registration Bureau (NRB) handles identification and registration.
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE marketing_professional (
    professional_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
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
    name VARCHAR(100),
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
    FOREIGN KEY (buyer_id) REFERENCES buyer(buyer_id)
);

CREATE TABLE compliance_certificates (
    certificate_id INT PRIMARY KEY AUTO_INCREMENT,
    farmer_id INT,
    status ENUM('pending', 'approved', 'rejected') NOT NULL,
    approved_by INT,
    FOREIGN KEY (farmer_id) REFERENCES farmer(farmer_id),
    FOREIGN KEY (approved_by) REFERENCES admins(admin_id),
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
    FOREIGN KEY (user_type_id) REFERENCES user_type(user_type_id),
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

-- For Kirinyaga (county_id = 12)
INSERT INTO sub_counties (name, county_id) VALUES ('Gichugu', 12);
INSERT INTO sub_counties (name, county_id) VALUES ('Kirinyaga central', 12);
INSERT INTO sub_counties (name, county_id) VALUES ('Kirinyaga east', 12);
INSERT INTO sub_counties (name, county_id) VALUES ('Kirinyaga west', 12);
INSERT INTO sub_counties (name, county_id) VALUES ('Mwea', 12);

-- For Kitui (county_id = 19)
INSERT INTO sub_counties (name, county_id) VALUES ('Kitui central', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitui east', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitui north', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitui south', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitui west', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Mwingi central', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Mwingi north', 19);
INSERT INTO sub_counties (name, county_id) VALUES ('Mwingi west', 19);

-- For Kwale (county_id = 5)
INSERT INTO sub_counties (name, county_id) VALUES ('Kangema', 5);
INSERT INTO sub_counties (name, county_id) VALUES ('Kinango', 5);
INSERT INTO sub_counties (name, county_id) VALUES ('Kwale', 5);
INSERT INTO sub_counties (name, county_id) VALUES ('Lunga Lunga', 5);
INSERT INTO sub_counties (name, county_id) VALUES ('Msambweni', 5);

-- For Laikipia (county_id = 27)
INSERT INTO sub_counties (name, county_id) VALUES ('Laikipia East', 27);
INSERT INTO sub_counties (name, county_id) VALUES ('Laikipia North', 27);
INSERT INTO sub_counties (name, county_id) VALUES ('Laikipia South', 27);
INSERT INTO sub_counties (name, county_id) VALUES ('Laikipia West', 27);

-- For Lamu (county_id = 8)
INSERT INTO sub_counties (name, county_id) VALUES ('Lamu east', 8);
INSERT INTO sub_counties (name, county_id) VALUES ('Lamu west', 8);

-- For Machakos (county_id = 32)
INSERT INTO sub_counties (name, county_id) VALUES ('Machakos town', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Masinga', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Matungulu', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Mwala', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Mavoko', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Kangundo', 32);
INSERT INTO sub_counties (name, county_id) VALUES ('Yatta', 32);

-- For Makueni (county_id = 20)
INSERT INTO sub_counties (name, county_id) VALUES ('Makueni', 20);
INSERT INTO sub_counties (name, county_id) VALUES ('Mbooni', 20);
INSERT INTO sub_counties (name, county_id) VALUES ('Kilome', 20);
INSERT INTO sub_counties (name, county_id) VALUES ('Kangundo', 20);
INSERT INTO sub_counties (name, county_id) VALUES ('Yatta', 20);

-- For Mandera (county_id = 6)
INSERT INTO sub_counties (name, county_id) VALUES ('Mandera central', 6);
INSERT INTO sub_counties (name, county_id) VALUES ('Mandera east', 6);
INSERT INTO sub_counties (name, county_id) VALUES ('Mandera north', 6);
INSERT INTO sub_counties (name, county_id) VALUES ('Mandera south', 6);
INSERT INTO sub_counties (name, county_id) VALUES ('Mandera west', 6);

-- For Marsabit (county_id = 4)
INSERT INTO sub_counties (name, county_id) VALUES ('Chalbi', 4);
INSERT INTO sub_counties (name, county_id) VALUES ('Marsabit central', 4);
INSERT INTO sub_counties (name, county_id) VALUES ('Marsabit north', 4);
INSERT INTO sub_counties (name, county_id) VALUES ('Marsabit south', 4);
INSERT INTO sub_counties (name, county_id) VALUES ('Marsabit west', 4);
INSERT INTO sub_counties (name, county_id) VALUES ('Saku', 4);
INSERT INTO sub_counties (name, county_id) VALUES ('Laisamis', 4);

-- For Meru (county_id = 15)
INSERT INTO sub_counties (name, county_id) VALUES ('Buuri', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Imenti central', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Imenti north', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Imenti south', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Meru', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Tigania east', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Tigania west', 15);
INSERT INTO sub_counties (name, county_id) VALUES ('Tharaka', 15);

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

-- For Nairobi (county_id = 48)
INSERT INTO sub_counties (name, county_id) VALUES ('Kamukunji', 48);
INSERT INTO sub_counties (name, county_id) VALUES ('Lang’ata', 48);
INSERT INTO sub_counties (name, county_id) VALUES ('Makadara', 48);
INSERT INTO sub_counties (name, county_id) VALUES ('Nairobi Central', 48);
INSERT INTO sub_counties (name, county_id) VALUES ('Nairobi West', 48);
INSERT INTO sub_counties (name, county_id) VALUES ('Ruaraka', 48);
INSERT INTO sub_counties (name, county_id) VALUES ('Starehe', 48);
INSERT INTO sub_counties (name, county_id) VALUES ('Westlands', 48);

-- For Nakuru (county_id = 31)
INSERT INTO sub_counties (name, county_id) VALUES ('Gilgil', 31);
INSERT INTO sub_counties (name, county_id) VALUES ('Kuresoi North', 31);
INSERT INTO sub_counties (name, county_id) VALUES ('Kuresoi South', 31);
INSERT INTO sub_counties (name, county_id) VALUES ('Molo', 31);
INSERT INTO sub_counties (name, county_id) VALUES ('Nakuru Town East', 31);
INSERT INTO sub_counties (name, county_id) VALUES ('Nakuru Town West', 31);
INSERT INTO sub_counties (name, county_id) VALUES ('Njoro', 31);
INSERT INTO sub_counties (name, county_id) VALUES ('Rongai', 31;
INSERT INTO sub_counties (name, county_id) VALUES ('Subukia', 31);

-- For Nandi (county_id = 33)
INSERT INTO sub_counties (name, county_id) VALUES ('Aldai', 33);
INSERT INTO sub_counties (name, county_id) VALUES ('Chesumei', 33);
INSERT INTO sub_counties (name, county_id) VALUES ('Nandi Hills', 33);
INSERT INTO sub_counties (name, county_id) VALUES ('Tinderet', 33);

-- For Narok (county_id = 21)
INSERT INTO sub_counties (name, county_id) VALUES ('Emurua Dikirr', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Kajiado Central', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Kajiado East', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Kajiado North', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Kajiado South', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Kajiado West', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Narok East', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Narok North', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Narok South', 21);
INSERT INTO sub_counties (name, county_id) VALUES ('Narok West', 21);

-- For Nyamira (county_id = 37)
INSERT INTO sub_counties (name, county_id) VALUES ('Boke', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Borabu', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Manga', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Masaba North', 37);
INSERT INTO sub_counties (name, county_id) VALUES ('Masaba South', 37);

-- For Nyandarua (county_id = 36)
INSERT INTO sub_counties (name, county_id) VALUES ('Gatimu', 36);
INSERT INTO sub_counties (name, county_id) VALUES ('Kangema', 36);
INSERT INTO sub_counties (name, county_id) VALUES ('Karatina', 36);
INSERT INTO sub_counties (name, county_id) VALUES ('Ol Kalou', 36);
INSERT INTO sub_counties (name, county_id) VALUES ('Rurii', 36);

-- For Nyeri (county_id = 7)
INSERT INTO sub_counties (name, county_id) VALUES ('Gikondi', 7);
INSERT INTO sub_counties (name, county_id) VALUES ('Kieni East', 7);
INSERT INTO sub_counties (name, county_id) VALUES ('Kieni West', 7);
INSERT INTO sub_counties (name, county_id) VALUES ('Mathira East', 7);
INSERT INTO sub_counties (name, county_id) VALUES ('Mathira West', 7);
INSERT INTO sub_counties (name, county_id) VALUES ('Othaya', 7);

-- For Samburu (county_id = 25)
INSERT INTO sub_counties (name, county_id) VALUES ('Samburu East', 25);
INSERT INTO sub_counties (name, county_id) VALUES ('Samburu North', 25);
INSERT INTO sub_counties (name, county_id) VALUES ('Samburu South', 25);
INSERT INTO sub_counties (name, county_id) VALUES ('Samburu West', 25);

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

-- For Kisii (county_id = 40)
INSERT INTO sub_counties (name, county_id) VALUES ('Bomachoge', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Bomachoge Borabu', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Bobasi', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Nyaribari Chache', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Nyaribari Masaba', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitutu Chache', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitutu Chache North', 40);
INSERT INTO sub_counties (name, county_id) VALUES ('Kitutu Chache South', 40);

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
