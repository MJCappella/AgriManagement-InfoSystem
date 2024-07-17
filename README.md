# Agriculture MIS (AMIS Project)
The following is the progress::
- [x] UML Use Case UML design
- [x] Database design
- [*] Backend development
- [ ] Frontend development
- [ ] Integration and testing
- [ ] Release
## Description
AMIS is a client-server web application where the client in the case of this system, is the farmers, traders, buyers and government agencies that use client side applications or web browsers to interact with the system while the server is the system which is the data server that hosts the AMIS.
### Users of the system
#### 1. Farmers
The system is convenient and simple to use.Farmers can access timely information on market prices, demand trends and consumer preferences , enabling them to make informed decisions about what crops to produce and when to sell therefore maximizing their profits.
#### 2. Consumers
Agriculture marketing information system enhances price transparency in agricultural markets ,allowing consumers to make more informed purchasing decisions and access affordable and diverse food options
#### 3. Traders and Agribusinesses 
AMIS provides traders and agribusinesses with valuable market intelligence, enabling them to identify profitable market opportunities , optimize their sourcing and procurement strategies, and effectively manage inventory levels.
#### 4. Government Agencies
The system enables government agencies to monitor market dynamics ,detect market distortions and enforce regulations related to fair trade practices ,consumer protection and food safety.
## Design
### Use Case UML diagram
![AMIS-Use Case Diagram](/.idea/uml-usecases/overview.png)


![use case diagram](/.idea/uml-usecases/individual.png)

## Detailed Use Case Descriptions

**<span style="color: #007377;text-decoration:underline">A. Farmers</span>**

**View Market Prices**

* **Goal:** Farmers can access up-to-date market prices for their crops to make informed pricing decisions.
* **Actors:** Farmers
* **Preconditions:** Farmer is logged into the system.
* **Main Flow:**
    1. Farmer logs into the system.
    2. Farmer navigates to the "Market Prices" section.
    3. System displays current market prices for various crops.
    4. Farmer views and analyzes the prices.

**Track Crop Yields**

* **Goal:** Farmers input and monitor crop yields to optimize planning and yield.
* **Actors:** Farmers
* **Preconditions:** Farmer is logged into the system.
* **Main Flow:**
    1. Farmer logs into the system.
    2. Farmer navigates to the "Crop Yields" section.
    3. Farmer inputs yield data.
    4. System records and tracks yield data.
    5. Farmer reviews yield history and trends.

**Analyze Demand Trends**

* **Goal:** Farmers analyze demand trends to decide which crops to plant.
* **Actors:** Farmers
* **Preconditions:** Farmer is logged into the system.
* **Main Flow:**
    1. Farmer logs into the system.
    2. Farmer navigates to the "Demand Trends" section.
    3. System displays demand trends for various crops.
    4. Farmer analyzes trends to make planting decisions.

**Access Transportation Information**

* **Goal:** Farmers find transportation options, compare prices, and arrange logistics for crop delivery.
* **Actors:** Farmers
* **Preconditions:** Farmer is logged into the system.
* **Main Flow:**
    1. Farmer logs into the system.
    2. Farmer navigates to the "Transportation Information" section.
    3. System displays transportation options and prices.
    4. Farmer arranges logistics for crop delivery.

**<span style="color: #007377;text-decoration:underline">B. Buyers</span>**

**Search for Crops**

* **Goal:** Buyers search for available crops from various farmers, compare prices, and make purchasing decisions.
* **Actors:** Buyers
* **Preconditions:** Buyer is logged into the system.
* **Main Flow:**
    1. Buyer logs into the system.
    2. Buyer navigates to the "Search for Crops" section.
    3. Buyer enters search criteria.
    4. System displays search results.
    5. Buyer compares prices and makes purchasing decisions.

**View Market Trends**

* **Goal:** Buyers use market analysis tools to view trends and data for procurement planning.
* **Actors:** Buyers
* **Preconditions:** Buyer is logged into the system.
* **Main Flow:**
    1. Buyer logs into the system.
    2. Buyer navigates to the "Market Trends" section.
    3. System displays market trends and data.
    4. Buyer analyzes trends for procurement planning.

**Manage Orders**

* **Goal:** Buyers place orders, track order status, and manage delivery schedules.
* **Actors:** Buyers
* **Preconditions:** Buyer is logged into the system.
* **Main Flow:**
    1. Buyer logs into the system.
    2. Buyer navigates to the "Manage Orders" section.
    3. Buyer places an order.
    4. System tracks order status.
    5. Buyer manages delivery schedules.

**Negotiate Contracts**

* **Goal:** Buyers generate quotes, negotiate contract terms, and track contract performance.
* **Actors:** Buyers
* **Preconditions:** Buyer is logged into the system.
* **Main Flow:**
    1. Buyer logs into the system.
    2. Buyer navigates to the "Negotiate Contracts" section.
    3. Buyer generates a quote.
    4. Buyer negotiates contract terms with the farmer.
    5. System tracks contract performance.

**<span style="color: #007377;text-decoration:underline">C. Government Agencies</span>**

**Market Monitoring**

* **Goal:** Monitor market prices, crop availability, and supply chain activities.
* **Actors:** Government Agencies
* **Preconditions:** Government agency user is logged into the system.
* **Main Flow:**
    1. User logs into the system.
    2. User navigates to the "Market Monitoring" section.
    3. System displays market prices, crop availability, and supply chain data.
    4. User monitors and analyzes data.

**Data Collection**

* **Goal:** Collect and analyze data for policy-making and agricultural support programs.
* **Actors:** Government Agencies
* **Preconditions:** Government agency user is logged into the system.
* **Main Flow:**
    1. User logs into the system.
    2. User navigates to the "Data Collection" section.
    3. System collects and displays relevant data.
    4. User analyzes data for policy-making and support

**<span style="color: #007377;text-decoration:underline">D. Marketing Professionals</span>**

**Market Analysis**

* **Goal:** Conduct market analysis to understand trends, pricing, and competition.
* **Actors:** Marketing Professionals
* **Preconditions:** Marketing professional is logged into the system.
* **Main Flow:**
    1. User logs into the system.
    2. User navigates to the "Market Analysis" section.
    3. System displays market analysis tools and data.
    4. User conducts market analysis.

**Manage Sales**

* **Goal:** Handle sales transactions, process orders, and manage customer accounts.
* **Actors:** Marketing Professionals
* **Preconditions:** Marketing professional is logged into the system.
* **Main Flow:**
    1. User logs into the system.
    2. User navigates to the "Manage Sales" section.
    3. User handles sales transactions and processes orders.
    4. System manages customer accounts and tracks sales.

**Customer Engagement**

* **Goal:** Engage customers through marketing campaigns, feedback surveys, and loyalty programs.
* **Actors:** Marketing Professionals
* **Preconditions:** Marketing professional is logged into the system.
* **Main Flow:**
    1. User logs into the system.
    2. User navigates to the "Customer Engagement" section.
    3. User creates and manages marketing campaigns.
    4. System collects feedback and manages loyalty programs.

**Regulatory Compliance**

* **Goal:** Ensure marketing activities comply with regulations.
* **Actors:** Marketing Professionals
* **Preconditions:** Marketing professional is logged into the system.
* **Main Flow:**
    1. User logs into the system.
    2. User navigates to the "Regulatory Compliance" section.
    3. System displays compliance data.
    4. User monitors and ensures compliance with regulations.
