SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS business;
CREATE TABLE business (
   id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(255) NOT NULL,
   type VARCHAR(255) NOT NULL,
   phone VARCHAR(255),
   website VARCHAR(255),
   street VARCHAR(255),
   city VARCHAR(255),
   state VARCHAR(255),
   zipcode INT(11),
   latitude FLOAT,
   longitude FLOAT
)ENGINE=InnoDB;

DROP TABLES IF EXISTS item;
CREATE TABLE item (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) UNIQUE NOT NULL
)ENGINE=InnoDB;

DROP TABLE IF EXISTS category;
CREATE TABLE category (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) NOT NULL
)ENGINE=InnoDB;

DROP TABLE IF EXISTS business_category_item;
CREATE TABLE business_category_item (
  bid INT(11) not null,
  cid INT(11) not null,
  iid INT(11) not null,
  FOREIGN KEY(bid) REFERENCES business(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(cid) REFERENCES category(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY(iid) REFERENCES item(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY (bid,cid,iid)
)ENGINE=InnoDB;


SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO category(name) values ("Household"), ("Bedding and Bath"),
("Children's Goods"), ("Appliances - Small"),("Appliances - Large"),
("Building and Home Improvement"),("Wearable Items"),("Useable Electronics"),
("Sporting Equipment and Camping"),("Garden"),("Food"),("Medical Supplies"),
("Office Equipment"),("Packing Materials"),("Miscellaneous"),("Repair Items");
/*
+----+--------------------------------+
| id | name                           |
+----+--------------------------------+
|  1 | Household                      |
|  2 | Bedding and Bath               |
|  3 | Children's Goods               |
|  4 | Appliances - Small             |
|  5 | Appliances - Large             |
|  6 | Building and Home Improvement  |
|  7 | Wearable Items                 |
|  8 | Useable Electronics            |
|  9 | Sporting Equipment and Camping |
| 10 | Garden                         |
| 11 | Food                           |
| 12 | Medical Supplies               |
| 13 | Office Equipment               |
| 14 | Packing Materials              |
| 15 | Miscellaneous                  |
| 16 | Repair Items                   |
+----+--------------------------------+
*/

INSERT INTO item(name) values
("Arts and crafts"), ("Barbeque grills"), ("Books"), ("Canning jars"),
("Cleaning supplies"), ("Clothes hangers"), ("Cookware"), ("Dishes"),
("Fabric"), ("Food storage containers"), ("Furniture"),("Blankets"),
("Comforters"), ("Linens"), ("Sheets"), ("Small rugs"), ("Towels"),
("Baby carriers"),("Baby gates"),("Bike trailers"), ("Child car seats"),
("Crayons"), ("Cribs"), ("Diapers"),("High chairs"),("Maternity"),
("Musical instruments"),("Nursing items"), ("Playpens"),("School supplies"),
("Strollers"),("Toys"),("Blenders"),("Dehumidifiers"),("Fans"),("Microwaves"),
("Space heaters"),("Toasters"),("Vacuum cleaners"),("Dishwashers"),("Freezers"),
("Refrigerators"),("Stoves"),("Washers/dryers"),("Bricks"),("Carpet padding"),
("Carpets"),("Ceramic tiles"),("Doors"),("Drywall"),("Electrical supplies"),
("Hand tools"),("Hardware"),("Insulation"),("Ladders"),("Light fixtures"),
("Lighting ballasts"),("Lumber"),("Motors"),("Paint"),("Pipe"),("Plumbing"),
("Power tools"),("Reusable metal items"),("Roofing"),("Vinyl"),("Windows"),
("Belts"),("Boots"),("Clothes"),("Coats"),("Hats"),("Rainwear"),("Sandals"),
("Shoes"), ("Calculators"),("Cameras"),("Cassette players"),("CD players"),("CD''s"),
("Cell phones"),("Computers"),("Curling irons"),("DVD players"),
("Game consoles"),("GPS systems"),("Hair dryers"),("Monitors"),("MP3 players"),
("Printers"),("Projectors"),("Receivers"),("Scanners"),("Speakers"),("Tablets"),
("Telephones"),("TV''s"),("Backpacks"),("Balls"),("Barbells"),("Bicycles"),
("Bike tires"),("Camping equipement"),("Day packs"),("Dumbbells"),
("Exercise equipement"),("Golf clubs"),("Helmets"),("Hiking boots"),
("Skateboards"),("Skis"),("Small boats"),("Snowshoes"),("Sporting goods"),("Tennis rackets"),
("Tents"),("Chain saws"),("Fencing"),("Garden pots"),("Garden tools"),
("Hand clippers"),("Hoses"),("Lawn furniture"),("Livestock supplies"),
("Loppers"),("Mowers"),("Seeders"),("Soil amendment"),("Sprinklers"),
("Wheel barrow"),("Beverages"),("Surplus garden produce"),
("Unopened canned coodes"),("Unopened packaged food"),("Adult diapers"),
("Blood pressure monitors"),("Canes"),("Crutches"),("Eye glasses"),
("Glucose meters"),("Hearing aids"),("Hospital beds"),("Reach extenders"),
("Shower chairs"),("Walkers"),("Wheelchairs"),("Fax machines"),("Headsets"),
("Office furniture"),("Paper shredders"),("Printer cartridge refilling"),
("Bubble wrap"),("Clean foam peanuts"),("Foam sheets"),("Egg cartons"),
("Firewood"),("Paper bags"),("Pet supplies"),("Shopping bags"),
("Vehicles / parts"),("Computer paper"),("Small appliances"),("Lamps"),
("Lawn power equipment"),("Outdoor gear"),("Upholstery, car"),("Upholstery, furniture");

--Reuse businesses
TRUNCATE business;
INSERT INTO business(name,type,phone,website,street,city,state,zipcode,latitude,longitude) values
("Albany-Corvallis ReUseIt", "Reuse", "541-754-9011",
  "https://groups.yahoo.com/neo/groups/albanycorvallisReUseIt/info", NULL,
  NULL, "OR", NULL, NULL, NULL),
("Arc Thrift Stores  (Corvallis)","Reuse","541-754-9011",NULL,
 "928 NW Beca Ave","Corvallis","OR",97330,44.578202,-123.261578),
("Arc Thrift Stores (Philomath)","Reuse","541-929-3946",NULL,
 "936 Main St","Philomath","OR",97370,44.540109,-123.372778),
 ("Beekman Place Antique Mall","Reuse","541-753-8250",NULL,
 "601 SW Western Blvd","Corvallis","OR",97333,44.560434,-123.266679),
 ("Benton County Extension / 4-H  Activities","Reuse","541-766-6750",NULL,
 "1849 NW 9th","Corvallis","OR",97330,44.585983,-123.256580),
 ("Benton County Master Gardeners","Reuse","541-766-6750",NULL,
 "1849 NW 9th St","Corvallis","OR",97330,44.585983,-123.256580),
 ("Book Bin","reuse","541-752-0040",NULL,
 "215 SW 4th St","Corvallis","OR",97333,44.563501,-123.262323),
 ("Browser's Bookstore","Reuse","888-758-1121",NULL,
 "121 NW 4th St","Corvallis","OR",97330,44.565198,-123.261401),
 ("Boys & Girls Club / STARS (after school programs)","Reuse","541-757-1909",NULL,
 "1112 NW Circle Blvd","Corvallis","OR",97330,44.588911, -123.263912),
 ("Buckingham Palace -Fri-Sun only","Reuse","541-752-7980",NULL,
 "600 SW 3rd St","Corvallis","OR",97333,44.559570, -123.263809),
 ("Calvary Community Outreach","Reuse","541-760-5941",NULL,
 "2125 NW Lester Ave","Corvallis","OR",97330,44.607775, -123.277824),
 ("CARDV (Center Against Rape/Domestic Violence)","Reuse","541-758-0219",NULL,
  "4786 SW Philomath Blvd","Corvallis","OR",97333,44.553110, -123.304936),
 ("Career Closet for Women (drop-off at)","Reuse","541-754-6979",NULL,
"942 NW 9th, Ste.A","Corvallis","OR",97330,44.574606, -123.263146),
 ("Cat's Meow Humane Society Thrift Shop","Reuse","541-757-0573",NULL,
 "411 SW 3rd St","Corvallis","OR",97333,44.561206, -123.262348),
 ("Children's Farm Home","Reuse","541-757-1852",NULL,
 "4455 NE Hwy 20","Corvallis","OR",97330,44.608628, -123.214491),
 ("Chintimini Wildlife Rehabilitation Ctr","Reuse","541-745-5324",NULL,
 "311 Lewisburg Rd","Corvallis","OR",97330,44.629237, -123.247062),
 ("Community Outreach (homeless shelter","Reuse","541-758-3000",NULL,
 "865 NW Reiman","Corvallis","OR",97330,44.573419, -123.262274),
 ("Corvallis Environmental Center","Reuse","541-753-9211",NULL,
 "214 SW Monroe Ave","Corvallis","OR",97330,44.564456, -123.260485),
 ("Corvallis Bicycle Collective","Reuse","541-224-6885",NULL,
 "33900 SE Roche Ln/Hwy 34","Corvallis","OR",97333,44.563640, -123.251145),
 ("Corvallis Furniture","Reuse","541-231-8103",NULL,
 "720 NE Granger Ave, Bldg J","Corvallis","OR",97330,44.628458, -123.234507),
 ("Corvallis-Uzhhorod Sister Cities/The TOUCH Project","Reuse","541-753-5170","http://www.sistercities.corvallis.or.us/uzhhorod",
 NULL,"Corvallis","OR",NULL,NULL,NULL),
 ("Cosmic Chameleon","Reuse","541-752-9001",NULL,
 "138 SW 2nd St","Corvallis","OR",97333,44.563682, -123.260586),
 ("Craigslist (corvallis.craigslist.org) and Freecycle.org","Reuse",NULL,"https://corvallis.craigslist.org/",
NULL,"Corvallis","OR",NULL,NULL,NULL),
 ("First Alternative Co-op Recycling Center ","Reuse","541-753-3115",NULL,
 "1007 SE 3rd St","Corvallis","OR",97333,44.554015, -123.264488),
 ("First Alternative Co-op Store (South store)","Reuse","541-753-3115",NULL,
"1007 SE 3rd St","Corvallis","OR",97333,44.554015, -123.264564),
 ("First Alternative Co-op Store (North store)","Reuse","541-452-3115",NULL,
"2855 NW Grant Ave","Corvallis","OR",97330,44.579052, -123.282294),
 ("Furniture Exchange","Reuse","541-833-0183",NULL,
 "210 NW 2nd St","Corvallis","OR",97339,44.565636, -123.259520),
 ("Furniture Share (formerly Benton FS)","Reuse","541-754-9511",NULL,
"155 SE Lilly Ave","Corvallis","OR",97333,44.548663, -123.264524),
 ("Home Grown Gardens","Reuse","541-758-2137",NULL,
 "4845 SE 3rd St","Corvallis","OR",97333,44.512087, -123.268783),
 ("Garland Nursery ","Reuse","541-753-6601",NULL,
 "5470 NE Hwy 20","Corvallis","OR",97330,44.617737, -123.212621),
 ("Goodwill Industries ","Reuse","541-752-8278",NULL,
 "1325 NW 9th St","Corvallis","OR",97330,44.578575, -123.259647),
 ("Habitat for Humanity ReStore ","Reuse","541-752-6637",NULL,
 "4840 SW Philomath Blvd","Corvallis","OR",97333,44.552384, -123.305805),
 ("Happy Trails Records, Tapes & CDs","Reuse","541-752-9032",NULL,
 "100 SW 3rd St","Corvallis","OR",97330,44.564482, -123.261284),
 ("Heartland Humane Society ","Reuse","541-757-9000",NULL,
 "398 SW Twin Oaks Cir","Corvallis","OR",97333,44.553200, -123.268916),

 ("Home Life Inc. (for develop. disabled)","Reuse","541-753-9015",NULL,
 "2068 NW Fillmore","Corvallis","OR",97330,44.575662, -123.275494),
 ("Jackson Street Youth Shelter","Reuse","541-754-2404",NULL,
 "555 NW Jackson St","Corvallis","OR",97330,44.566511, -123.262987),
 ("Linn Benton Food Share (lg. food donations)","Reuse","541-752-1010",NULL,
 "545 SW 2nd","Corvallis","OR",97333,44.559479, -123.261779),
 ("Lions Club (box inside Elks Lodge)","Reuse","541-758-0222",NULL,
 "1400 NW 9th St","Corvallis","OR",97330,44.580357, -123.260337),
 ("Love INC (for low income citizens)","Reuse","541-757-8111",NULL,
 "2330 NW Professional Dr #102","Corvallis","OR",97330,44.590097, -123.278006),
 ("Mario Pastega House (Good Sam patient family housing)","Reuse","541-768-4650",NULL,
 "3505 NW Samaritan Dr","Corvallis","OR",97330,44.600713, -123.249359 ),
 ("Mary's River Gleaners (for low income citizens)","Reuse","541-752-1010",NULL,
 "PO Box 2309","Corvallis","OR",NULL,NULL,NULL),
 ("Midway Farms (Hway 20 btw Corvallis & Albany)","Reuse","541-740-6141",NULL,
 "6980 US-20","Albany","OR",97321,44.637067, -123.178143),
 ("Neighbor to Neighbor (food pantry)","Reuse","541-929-6614",NULL,
 "1123 Main St","Philomath","OR",97370,44.540972, -123.370059),
 ("Osborn Aquatic Center","Reuse","541-766-7946",NULL,
 "1940 NW Highland Dr","Corvallis","OR",97330,44.588002, -123.263236),
 ("OSU Emergency Food Pantry","Reuse","541-737-3473",NULL,
 "2150 SW Jefferson Way","Corvallis","OR",97333,44.564151, -123.276415),
 ("OSU Folk Club Thrift Shop ","Reuse","541-752-4733",NULL,
 "144 NW 2nd St","Corvallis","OR",97330,44.565265, -123.259759 ),
 ("OSU Organic Growers Club (Crop & Soil Science Dept)","Reuse","541-737-6810","http://cropandsoil.oregonstate.edu/organic_grower",
 NULL,"Corvallis","OR",97331,NULL,NULL),
 ("Pak Mail (Timberhill Shopping Ctr)","Reuse","541-754-8411",NULL,
 "2397 NW Kings Blvd","Corvallis","OR",97330,44.591504, -123.272839),
 ("Parent Enhancement Program ","Reuse","541-758-8292",NULL,
 "421 NW 4th St","Corvallis","OR",97330,44.568143, -123.260002),
 ("Pastors for Peace-Caravan to Cuba (Mike Beilstein)","Reuse","541-754-1858","www.ccds.org",
 NULL,"Corvallis","OR",NULL,NULL,NULL),
 ("Philomath Community Garden (Chris Shonnard)","Reuse","541-929-3524","http://philomathcommunityservices.org/",
 "360 S 9th St","Philomath","OR",97370,44.535838, -123.374337),
 ("Philomath Community Services (food & kids stuff)","Reuse","541-929-2499",NULL,
 "360 S 9th St","Philomath","OR",97370,44.535838, -123.374337),
 ("Play It Again Sports","Reuse","541-754-7529",NULL,
 "1422 NW 9th St","Corvallis","OR",97330,44.580981, -123.260111),
 ("Presbyterian Piecemakers (cotton quilts)","Reuse","541-753-7516",NULL,
 "114 SW 8th St","Corvallis","OR",97333,44.565605, -123.266716),
 ("Public Library Corvallis, Friends of","Reuse","541-766-6928",NULL,
 "645 NW Monroe Ave","Corvallis","OR",97330,44.565931, -123.264400),
 ("Quilts From Caring Hands (cotton quilts)","Reuse","541-758-8161",NULL,
 "1495 NW 20th St,","Corvallis","OR",97330,44.581415, -123.272780),
 ("Rapid Refill Ink ","Reuse","541-758-8444",NULL,
 "254 SW Madison Ave","Corvallis","OR",97333,44.563400, -123.261314),
 ("Replay Children's Wear ","Reuse","541-753-6903",NULL,
 "250 NW 1st St","Corvallis","OR",97330,44.565823, -123.258180),
 ("re·volve (women's resale boutique)","Reuse","541-754-1154",NULL,
 "103 SW 2nd St","Corvallis","OR",97330,44.564091, -123.259470),
 ("Schools (Public, Private, Charter)","Reuse",NULL,NULL,
 NULL,"Corvallis","OR",NULL,NULL,NULL),
 ("Second Glance","Reuse","541-758-9099",NULL,
 "312 SW 3rd Street ","Corvallis","OR",97333,44.562338, -123.262363),
 ("The Annex","Reuse","541-758-9099",NULL,
 "214 SW Jefferson","Corvallis","OR",97333,44.562275, -123.261496),
 ("The Alley","Reuse","541-753-4069",NULL,
 "312 SW Jefferson","Corvallis","OR",97333,44.562509, -123.262397),
 ("Senior Center of Corvallis","Reuse","541-766-6959",NULL,
 "2601 NW Tyler Ave","Corvallis","OR",97330,44.573254, -123.280371),
 ("South Corvallis Food Bank ","Reuse","541-753-4263",NULL,
 "1798 SW 3rd St","Corvallis","OR",97333,44.546923, -123.267621),
 ("St. Vincent de Paul Food Bank","Reuse","541-757-1988",NULL,
 "501 NW 25th Street","Corvallis","OR",97330,44.573343, -123.278371),
 ("Stone Soup  (St Mary's Church)","Reuse","541-757-1988",NULL,
 "501 NW 25th Street","Corvallis","OR",97330,44.573220, -123.278478),
 ("UPS Store (Philomath)","Reuse","541-752-1830",NULL,
 "5060 SW Philomath Blvd","Corvallis","OR",97333,44.552258, -123.307601),
 ("UPS Stores (Corvallis)","Reuse","541-752-0056",NULL,
 "922 NW Circle Blvd #160","Corvallis","OR",97330,44.588301, -123.257593),
 ("Vina Moses (for low income citizens)","Reuse","541-753-1420",NULL,
 "968 NW Garfield Ave","Corvallis","OR",97330,44.583060, -123.260488),
 ("Spaeth Heritage House","Reuse","541-307-0349",NULL,
 "135 N 13th St","Philomath","OR",97370,44.541078, -123.367801);

 /*("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("","Reuse"),
 ("");
*/
--Repair businesses
INSERT INTO business(name,type,phone,website,street,city,state,zipcode,latitude,longitude)
VALUES
('Book Binding', 'Repair', '541-757-9861', 'http://www.cornerstoneassociates.com/bj-bookbinding-about-us.html',
'108 SW 3rd St, ', 'Corvallis', 'OR', 97333, 44.564451, -123.261360),
('Cell Phone Sick Bay', 'Repair', '541-230-1785', 'http://www.cellsickbay.com/index.html',
'252 Sw Madison Ave, Suite 110', 'Corvallis', 'OR', 97333, 44.563434, -123.260865),
('Geeks ''N'' Nerds', 'repair', '541-753-0018', 'http://www.computergeeksnnerds.com/',
'950 Southeast Geary St Unit D', 'Albany', 'OR', 97321, 44.632876, -123.083662 ),
('Specialty Sewing By Leslie', 'Repair', '541-758-4556', 'http://www.specialtysewing.com/Leslie_Seamstress/Welcome.html',
'225 SW Madison Ave', 'Corvallis', 'OR', 97333, 44.563553, -123.260713),
('Covallis Technical', 'Repair', '541-704-7009', 'http://www.corvallistechnical.com/',
'966 NW Circle Blvd', 'Corvallis', 'OR', 97330 , 44.588949, -123.257731),
('Bellevue Computers',  'Repair', '541-757-3487',  'http://www.bellevuepc.com/',
'1865 NW 9th St',  'Corvallis', 'OR', 97330 , 44.586395, -123.255074),
('OSU Repair Fair',  'Repair',  '541-737-5398',  'http://fa.oregonstate.edu/surplus',
'644 S.W. 13th St',  'Corvallis',  'OR', 97333 , 44.561585, -123.272634),
('P.K Furniture Repair & Refinishing ',  'Repair',  '541-230-1727',  'http://www.pkfurniturerefinishing.net/',
'5270 Corvallis-Newport Hwy',  'Toledo', 'OR' , 97391 , 44.629716, -123.954976),
('Furniture Restoration Center',  'Repair',  '541-929-6681',  'http://restorationsupplies.com/',
'1321 Main St',  'Philomath',  'OR', 97370 , 44.540307, -123.367144);

/*
  name VARCHAR(255) NOT NULL,
  type VARCHAR(255) NOT NULL,
  phone VARCHAR(255),
  website VARCHAR(255),
  street VARCHAR(255),
  city VARCHAR(255),
  state VARCHAR(255),
  zipcode INT(11),
  latitude FLOAT,
  longitude FLOAT
*/
