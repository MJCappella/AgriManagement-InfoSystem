# Agriculture MIS (AMIS Project)
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
![AMIS-Use Case Diagram](https://github.com/essyngero/amis-project-/assets/167772798/f8d53c68-5777-42ae-82b9-0e8fa674c50e)

``` puml
@startuml
rectangle "AMIS Use Case Overvew Diagram" #fafafa;text:007377;line:007377{
    left to right direction
    rectangle "Clients" #e2efff;text:green{
        actor "Consumer" as cus #blue
        actor "Farmer" as frm #green
        actor "Government" as gok #indigo
        actor "Analyst" as anl #fb8500
    }
    package "Agriculture MIS (AMIS)" as amis #e2e2e2;line:green;line.bold {
        usecase UC0 as "Management\nProducts managements\nMarket Updates" << backend>> #f5024a;text:white
        usecase UC1 as " " <<homepage>> #line.dotted;line:blue
        usecase UC2 as "Purchase products\nGive feedback" <<login>> #007377;text:white
        usecase UC3 as "Add/Delete Products" <<login>> #007377;text:white
        usecase UC4 as "View Market\nGenerate Reports" <<login>> #007377;text:white
    }
    database amisdb
        note left
            Contains all the information
        end note
    amis -> amisdb
    cus --> UC1 #blue;line.dotted
    frm --> UC1 #green;line.dotted
    gok --> UC1 #indigo;line.dotted
    anl --> UC1 #fb8500;line.dotted
    cus --> UC2 #blue
    frm --> UC3 #green;line.bold
    frm -down-> UC4 #green
    anl -down-> UC4 #fb8500
    gok -down-> UC4 #indigo
    cus -down-> UC4 #blue
    skinparam actorStyle awesome
    :Admin:<<system>>#line:green 
    Admin -up-> (UC0) #red: Monitor all\n operations
}
    
@enduml

```
![use case diagram](https://github.com/essyngero/amis-project-/assets/167772798/79376918-468d-47d2-b8b0-5417a2385c38)

``` puml
@startuml
rectangle "AMIS Use Case Individual Diagrams" #fafafa;text:007377;line:007377{
    rectangle Farmer #line:green;line.bold;text:green[
        =Farmer 
        ----
        ""- View Market Prices""
        ""- Track Crop Yields ""
        ""- Analyze Demand Trends ""
        ""- Access Transportation ""
    ]
    rectangle Buyers #line:blue;line.bold;text:blue[
        =Buyers
        ----
        ""- Search for Crops""
        ""- View Market Trends""
        ""- Manage Orders   ""
        ""- Negotiate Contracts""
    ]
    rectangle Government #line:indigo;line.bold;text:indigo[
        =Government Agencies
        ----
        ""- Market Monitoring""
        ""- Data Collection""
        ""- Regulatory Compliance ""
    ]
    rectangle Analyst #line:fb8500;line.bold;text:fb8500[
        =Marketing Professionals
        ----
        ""- Market Analysis   ""
        ""- Manage Sales    ""
        ""- Customer Engagement  ""
        ""- Regulatory Compliance  ""
    ]
}    
@enduml


```
