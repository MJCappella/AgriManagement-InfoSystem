CREATE DATABASE AMIS;
USE AMIS;

CREATE TABLE UserType (
    user_type_id INT AUTO_INCREMENT PRIMARY KEY,
    user_type ENUM('farmer', 'buyer', 'government', 'transporter','marketing','admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE Admin (
    AdminID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    id_number INT(9) NOT NULL,
    Password VARCHAR(255),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE TwoFactorAuth (
    AuthID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    user_type_id INT,
    Code VARCHAR(6),
    Status ENUM('pending', 'verified', 'expired', 'rejected') NOT NULL,
    SentAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    VerifiedAt TIMESTAMP,
    FOREIGN KEY (user_type_id) REFERENCES UserType(user_type_id)
);

CREATE TABLE Farmer (
    FarmerID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    Password VARCHAR(255),
    Location VARCHAR(100),
    Phone VARCHAR(20),
    ComplianceStatus ENUM('pending', 'approved', 'rejected') NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UpdatedBy INT
);

CREATE TABLE Buyer (
    BuyerID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    Password VARCHAR(255),
    Phone VARCHAR(20),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UpdatedBy INT
);

CREATE TABLE Transporter (
    TransportID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    Phone VARCHAR(20),
    Description TEXT,
    Price DECIMAL(10, 2),
    Availability ENUM('available', 'engaged', 'no service') NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UpdatedBy INT
);

CREATE TABLE GovernmentAgency (
    AgencyID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    Password VARCHAR(255),
    Location VARCHAR(100),
    Phone VARCHAR(20),
    NRBInfo VARCHAR(255), -- National Registration Bureau (NRB) handles identification and registration.
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UpdatedBy INT
);



CREATE TABLE MarketingProfessional (
    ProfessionalID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Email VARCHAR(100) UNIQUE,
    Password VARCHAR(255),
    Company VARCHAR(100),
    Phone VARCHAR(20),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UpdatedBy INT
);


CREATE TABLE Crops (
    CropID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Description TEXT,
    Price DECIMAL(10, 2),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UpdatedBy INT
);


CREATE TABLE Orders (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    FarmerID INT,
    BuyerID INT,
    CropID INT,
    Quantity INT,
    status ENUM('pending', 'confirmed', 'shipped', 'delivered') NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UpdatedBy INT,
    FOREIGN KEY (FarmerID) REFERENCES Farmer(FarmerID),
    FOREIGN KEY (BuyerID) REFERENCES Buyer(BuyerID)
);


CREATE TABLE ComplianceCertificates (
    CertificateID INT PRIMARY KEY AUTO_INCREMENT,
    FarmerID INT,
    Status ENUM('pending', 'approved', 'rejected') NOT NULL,
    approved_by INT,
    FOREIGN KEY (farmer_id) REFERENCES Farmers(user_id),
    FOREIGN KEY (approved_by) REFERENCES Admins(user_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE Transactions (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    transaction_code VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved') NOT NULL,
    FOREIGN KEY (farmer_id) REFERENCES Users(user_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE MarketPrices (
    price_id INT AUTO_INCREMENT PRIMARY KEY,
    crop_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    status  ENUM('effective', 'not effective', 'expired') NOT NULL,
    date DATE NOT NULL,
    FOREIGN KEY (crop_id) REFERENCES Crops(crop_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);


CREATE TABLE MarketTrends (
    trend_id INT AUTO_INCREMENT PRIMARY KEY,
    crop_id INT NOT NULL,
    trend_data TEXT,
    date DATE NOT NULL,
    FOREIGN KEY (crop_id) REFERENCES Crops(crop_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE DemandTrends (
    TrendID INT PRIMARY KEY AUTO_INCREMENT,
    CropID INT,
    Demand INT,
    Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UpdatedBy INT,
    FOREIGN KEY (CropID) REFERENCES Crops(CropID)
);


CREATE TABLE Yields (
    YieldID INT PRIMARY KEY AUTO_INCREMENT,
    FarmerID INT,
    CropID INT,
    Quantity INT,
    HarvestDate DATE,
    TransactionCode VARCHAR(100),
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UpdatedBy INT,
    FOREIGN KEY (FarmerID) REFERENCES Farmer(FarmerID),
    FOREIGN KEY (CropID) REFERENCES Crops(CropID)
);



CREATE TABLE CustomerFeedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    user_type_id INT NOT NULL,
    buyer_id INT NOT NULL,
    farmer_id INT NOT NULL,
    feedback TEXT,
    date DATE NOT NULL,
    FOREIGN KEY (user_type_id) REFERENCES Users(user_type_id),
    FOREIGN KEY (buyer_id) REFERENCES Buyers(buyer_id),
    FOREIGN KEY (farmer_id) REFERENCES Farmers(farmer_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT
);

CREATE TABLE Forex (
    ForexID INT PRIMARY KEY AUTO_INCREMENT,
    Date DATE NOT NULL,
    USD DECIMAL(10, 4),
    GBP DECIMAL(10, 4), 
    EUR DECIMAL(10, 4),
    CAD DECIMAL(10, 4),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT 
);


CREATE TABLE Counties (
    CountyID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL,
    Capital VARCHAR(100),
    Code INT NOT NULL
);

CREATE TABLE SubCounties (
    SubCountyID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL,
    CountyID INT NOT NULL,
    FOREIGN KEY (CountyID) REFERENCES Counties(CountyID)
);
