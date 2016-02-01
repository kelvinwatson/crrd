SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS business;
CREATE TABLE business (
   id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(255) NOT NULL,
   type VARCHAR(255) NOT NULL,
   phone VARCHAR(255) DEFAULT NULL,
   website VARCHAR(255) DEFAULT NULL,
   street VARCHAR(255) DEFAULT NULL,
   city VARCHAR(255) DEFAULT NULL,
   state VARCHAR(255) DEFAULT NULL,
   zipcode INT(11) DEFAULT NULL,
   latitude FLOAT DEFAULT NULL,
   longitude FLOAT DEFAULT NULL,
   info VARCHAR(255) DEFAULT NULL
)ENGINE=InnoDB;

DROP TABLES IF EXISTS item;
CREATE TABLE item (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255) UNIQUE NOT NULL,
url VARCHAR(255) DEFAULT NULL
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

DROP TABLES IF EXISTS operating_day;
CREATE TABLE operating_day (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
day VARCHAR(255) UNIQUE NOT NULL
)ENGINE=InnoDB;

DROP TABLES IF EXISTS open_hour;
CREATE TABLE open_hour (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
open_time TIME NOT NULL
)ENGINE=InnoDB;

DROP TABLES IF EXISTS close_hour;
CREATE TABLE close_hour (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
close_time TIME NOT NULL
)ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;

#item categories
INSERT INTO category(name) VALUES ("Household"), ("Bedding and Bath"),
("Children's Goods"), ("Appliances - Small"),("Appliances - Large"),
("Building and Home Improvement"),("Wearable Items"),("Useable Electronics"),
("Sporting Equipment and Camping"),("Garden"),("Food"),("Medical Supplies"),
("Office Equipment"),("Packing Materials"),("Miscellaneous"),("Repair Items");

#items
INSERT INTO item(name) VALUES
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
("Shoes"), ("Calculators"),("Cameras"),("Cassette players"),("CD players"),
("CD's"),("Cell phones"),("Computers"),("Curling irons"),("DVD players"),
("Game consoles"),("GPS systems"),("Hair dryers"),("Monitors"),("MP3 players"),
("Printers"),("Projectors"),("Receivers"),("Scanners"),("Speakers"),("Tablets"),
("Telephones"),("TV's"),("Backpacks"),("Balls"),("Barbells"),("Bicycles"),
("Bike tires"),("Camping equipment"),("Day packs"),("Dumbbells"),
("Exercise equipment"),("Golf clubs"),("Helmets"),("Hiking boots"),
("Skateboards"),("Skis"),("Small boats"),("Snowshoes"),("Sporting goods"),
("Tennis rackets"),("Tents"),("Chain saws"),("Fencing"),("Garden pots"),
("Garden tools"),("Hand clippers"),("Hoses"),("Lawn furniture"),
("Livestock supplies"),("Loppers"),("Mowers"),("Seeders"),("Soil amendment"),
("Sprinklers"),("Wheel barrow"),("Beverages"),("Surplus garden produce"),
("Unopened canned coodes"),("Unopened packaged food"),("Adult diapers"),
("Blood pressure monitors"),("Canes"),("Crutches"),("Eye glasses"),
("Glucose meters"),("Hearing aids"),("Hospital beds"),("Reach extenders"),
("Shower chairs"),("Walkers"),("Wheelchairs"),("Fax machines"),("Headsets"),
("Office furniture"),("Paper shredders"),("Printer cartridge refilling"),
("Bubble wrap"),("Clean foam peanuts"),("Foam sheets"),("Egg cartons"),
("Firewood"),("Paper bags"),("Pet supplies"),("Shopping bags"),
("Vehicles / parts"),("Computer paper"),("Small appliances"),("Lamps"),
("Lawn power equipment"),("Outdoor gear"),("Upholstery, car"),
("Upholstery, furniture"),("Screen repair");

#Reuse businesses
TRUNCATE business;
INSERT INTO business(name,type,phone,website,street,city,state,zipcode,latitude,longitude) VALUES
("Albany-Corvallis ReUseIt", "Reuse", "541-754-9011","https://groups.yahoo.com/neo/groups/albanycorvallisReUseIt/info",
NULL, NULL, "OR", NULL, NULL, NULL),
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
("Garland Nursery ","Reuse","541-753-6601",NULL,
"5470 NE Hwy 20","Corvallis","OR",97330,44.617737, -123.212621),
("Goodwill Industries ","Reuse","541-752-8278",NULL,
"1325 NW 9th St","Corvallis","OR",97330,44.578575, -123.259647),
("Home Grown Gardens","Reuse","541-758-2137",NULL,
"4845 SE 3rd St","Corvallis","OR",97333,44.512087, -123.268783),
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

#Repair businesses
INSERT INTO business(name,type,phone,website,street,city,state,zipcode,latitude,longitude,info)
VALUES
('Book Binding', 'Repair', '541-757-9861', 'http://www.cornerstoneassociates.com/bj-bookbinding-about-us.html',
'108 SW 3rd St, ', 'Corvallis', 'OR', 97333, 44.564451, -123.261360, 'Rebind and restore books.'),
('Cell Phone Sick Bay', 'Repair', '541-230-1785', 'http://www.cellsickbay.com/index.html',
'252 Sw Madison Ave, Suite 110', 'Corvallis', 'OR', 97333, 44.563434, -123.260865, 'Cell phones and tablets.'),
('Geeks ''N'' Nerds', 'repair', '541-753-0018', 'http://www.computergeeksnnerds.com/',
'950 Southeast Geary St Unit D', 'Albany', 'OR', 97321, 44.632876, -123.083662,'Repair computers of all kinds and cell phone repair; in home repair available'),
('Specialty Sewing By Leslie', 'Repair', '541-758-4556', 'http://www.specialtysewing.com/Leslie_Seamstress/Welcome.html',
'225 SW Madison Ave', 'Corvallis', 'OR', 97333, 44.563553, -123.260713,'Alterations and custom work.'),
('Covallis Technical', 'Repair', '541-704-7009', 'http://www.corvallistechnical.com/',
'966 NW Circle Blvd', 'Corvallis', 'OR', 97330 , 44.588949, -123.257731,'Repair computers and laptops'),

('Bellevue Computers',  'Repair', '541-757-3487',  'http://www.bellevuepc.com/',
'1865 NW 9th St',  'Corvallis', 'OR', 97330 , 44.586395, -123.255074,'Repair computers and laptops'),
('OSU Repair Fair',  'Repair',  '541-737-5398',  'http://fa.oregonstate.edu/surplus',
'644 S.W. 13th St',  'Corvallis',  'OR', 97333 , 44.561585, -123.272634,"Occurs twice per quarter in the evenings Small appliances, Bicycles, Clothing, Computers (hardware and software) Electronics (small items only) Housewares (furniture, ceramics, lamps, etc.)"),

('P.K Furniture Repair & Refinishing ',  'Repair',  '541-230-1727',  'http://www.pkfurniturerefinishing.net/',
'5270 Corvallis-Newport Hwy',  'Toledo', 'OR' , 97391 , 44.629716, -123.954976,'Complete restoration, complete refinishing, modifications, custom color matching, furniture stripping, chair press caning, repairs'),
('Furniture Restoration Center',  'Repair',  '541-929-6681',  'http://restorationsupplies.com/',
'1321 Main St',  'Philomath',  'OR', 97370 , 44.540307, -123.367144,'Restores all typers of furniture and has hardware for doing it yourself.'),

('Power Equipment',  'Repair',  '541-757-8075',  'https://corvallispowerequipment.stihldealer.net/',
'713 NE Circle Blvd',  'Corvallis',  'OR', 97330,44.589431, -123.250374,'Lawn and garden equipment, chain saws (Stihl, honda, shindiawh), hand held equipment.'),
('Robnett''s',  'Repair',  '541-753-5531',  'http://ww3.truevalue.com/robnetts/Home.aspx',
'400 SW 2nd St',  'Corvallis',  'OR', 97333,44.561150, -123.261699,'Adjustment and sharpening'),
('Footwise',  'Repair',  '541-757-0875',  'http://footwise.com/',
'301 SW Madison Ave #100',  'Corvallis',  'OR', 97333,44.563852, -123.261627,'Resoles berkenstock'),
('Sedlack',  'Repair',  '541-752-1498',  'http://www.sedlaksshoes.net/',
'225 SW 2nd St',  'Corvallis',  'OR', 97333, 44.563542, -123.260676,'Full resoles, elastic and velcros, sewing and patching, leather patches, zippers, half soles and heels.'),
('Foam Man',  'Repair',  '(541) 754-9378',  'http://www.thefoammancorvallis.com/',
'2511 NW 9th St',  'Corvallis',  'OR', 97330, 44.593444, -123.251752,'Replacement foam cusions for chairs and couches;  upholstery.');


#Operating days
INSERT INTO operating_day(day) VALUES
('Sun'),('Mon'),('Tue'),('Wed'),('Thu'),('Fri'),('Sat');

#Open hours
INSERT INTO open_hour(open_time) VALUES
('0:00:00'),('0:15:00'),('0:30:00'),('0:45:00'),
('1:00:00'),('1:15:00'),('1:30:00'),('1:45:00'),
('2:00:00'),('2:15:00'),('2:30:00'),('2:45:00'),
('3:00:00'),('3:15:00'),('3:30:00'),('3:45:00'),
('4:00:00'),('4:15:00'),('4:30:00'),('4:45:00'),
('5:00:00'),('5:15:00'),('5:30:00'),('5:45:00'),
('6:00:00'),('6:15:00'),('6:30:00'),('6:45:00'),
('7:00:00'),('7:15:00'),('7:30:00'),('7:45:00'),
('8:00:00'),('8:15:00'),('8:30:00'),('8:45:00'),
('9:00:00'),('9:15:00'),('9:30:00'),('9:45:00'),
('10:00:00'),('10:15:00'),('10:30:00'),('10:45:00'),
('11:00:00'),('11:15:00'),('11:30:00'),('11:45:00'),
('12:00:00'),('12:15:00'),('12:30:00'),('12:45:00'),
('13:00:00'),('13:15:00'),('13:30:00'),('13:45:00'),
('14:00:00'),('14:15:00'),('14:30:00'),('14:45:00'),
('15:00:00'),('15:15:00'),('15:30:00'),('15:45:00'),
('16:00:00'),('16:15:00'),('16:30:00'),('16:45:00'),
('17:00:00'),('17:15:00'),('17:30:00'),('17:45:00'),
('18:00:00'),('18:15:00'),('18:30:00'),('18:45:00'),
('19:00:00'),('19:15:00'),('19:30:00'),('19:45:00'),
('20:00:00'),('20:15:00'),('20:30:00'),('20:45:00'),
('21:00:00'),('21:15:00'),('21:30:00'),('21:45:00'),
('22:00:00'),('22:15:00'),('22:30:00'),('22:45:00'),
('23:00:00'),('23:15:00'),('23:30:00'),('23:45:00');

#Close hours
INSERT INTO close_hour(close_time) VALUES
('0:00:00'),('0:15:00'),('0:30:00'),('0:45:00'),
('1:00:00'),('1:15:00'),('1:30:00'),('1:45:00'),
('2:00:00'),('2:15:00'),('2:30:00'),('2:45:00'),
('3:00:00'),('3:15:00'),('3:30:00'),('3:45:00'),
('4:00:00'),('4:15:00'),('4:30:00'),('4:45:00'),
('5:00:00'),('5:15:00'),('5:30:00'),('5:45:00'),
('6:00:00'),('6:15:00'),('6:30:00'),('6:45:00'),
('7:00:00'),('7:15:00'),('7:30:00'),('7:45:00'),
('8:00:00'),('8:15:00'),('8:30:00'),('8:45:00'),
('9:00:00'),('9:15:00'),('9:30:00'),('9:45:00'),
('10:00:00'),('10:15:00'),('10:30:00'),('10:45:00'),
('11:00:00'),('11:15:00'),('11:30:00'),('11:45:00'),
('12:00:00'),('12:15:00'),('12:30:00'),('12:45:00'),
('13:00:00'),('13:15:00'),('13:30:00'),('13:45:00'),
('14:00:00'),('14:15:00'),('14:30:00'),('14:45:00'),
('15:00:00'),('15:15:00'),('15:30:00'),('15:45:00'),
('16:00:00'),('16:15:00'),('16:30:00'),('16:45:00'),
('17:00:00'),('17:15:00'),('17:30:00'),('17:45:00'),
('18:00:00'),('18:15:00'),('18:30:00'),('18:45:00'),
('19:00:00'),('19:15:00'),('19:30:00'),('19:45:00'),
('20:00:00'),('20:15:00'),('20:30:00'),('20:45:00'),
('21:00:00'),('21:15:00'),('21:30:00'),('21:45:00'),
('22:00:00'),('22:15:00'),('22:30:00'),('22:45:00'),
('23:00:00'),('23:15:00'),('23:30:00'),('23:45:00');


INSERT INTO business_category_item(bid,cid,iid) VALUES
(72,16,3),
(73,16,81),
(74,16,81),
(75,16,70),
(76,16,82),
(77,16,82),
(74,16,82),
(78,16,82),
(78,16,162),
(79,16,11),
(80,16,11),
(81,16,164),
(82,16,164),
(82,16,168), #awaiitng client response
(83,16,74),
(84,16,75),
(84,16,69),
(85,16,167);

INSERT INTO business(name,type) VALUES
('generic_repair_business', 'Repair'),
('generic_reuse_business', 'Reuse');

#generic_repair_business into bci table
INSERT INTO business_category_item(bid,cid,iid) VALUES
(86,16,81),
(86,16,162),
(86,16,3),
(86,16,70),
(86,16,82),
(86,16,11),
(86,16,163),
(86,16,164),
(86,16,165),
(86,16,74),
(86,16,75),
(86,16,69),
(86,16,166),
(86,16,167);
