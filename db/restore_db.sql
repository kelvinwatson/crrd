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

#REPAIR
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
(82,16,168),
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

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Albany-Corvallis
(1,5,40),(1,5,41),(1,5,42),(1,5,43),(1,5,44),
(1,4,33),(1,4,34),(1,4,35),(1,4,36),(1,4,37),(1,4,38),(1,4,39),
(1,15,186),
(1,2,12),(1,2,13),(1,2,14),(1,2,15),(1,2,16),(1,2,17),
(1,9,116),
(1,1,3),(1,3,3),
(1,15,157),(1,15,159),
(1,6,45),(1,6,46),(1,6,47),(1,6,48),(1,6,49),(1,6,50),(1,6,51),(1,6,52),(1,6,53),(1,6,54),(1,6,55),(1,6,56),(1,6,57),(1,6,58),(1,6,59),(1,6,60),(1,6,61),(1,6,62),(1,6,63),(1,6,64),(1,6,65),(1,6,66),(1,6,67),
(1,8,79),
(1,8,81),
(1,3,1),(1,3,18),(1,3,19),(1,3,20),(1,3,21),(1,3,22),(1,3,23),(1,3,24),(1,3,25),(1,3,26),(1,3,27),(1,3,28),(1,3,29),(1,3,31),(1,3,32),(1,3,70),
(1,7,68),(1,7,69),(1,7,70),(1,7,71),(1,7,72),(1,7,73),(1,7,74),(1,7,75),
(1,15,161),
(1,13,82),(1,13,88),
(1,15,155),
(1,12,139),
(1,1,9),(1,15,9),
(1,15,156),
(1,11,131),(1,11,133),(1,11,134),
(1,11,12),
(1,1,10),
(1,1,11),
(1,10,117),(1,10,118),(1,10,120),(1,10,121),(1,10,122),(1,10,123),(1,10,124),(1,10,125),(1,10,126),(1,10,127),(1,10,128),(1,10,129),(1,10,130),
(1,10,119),
(1,8,76),(1,8,77),(1,8,78),(1,8,80),(1,8,83),(1,8,84),(1,8,85),(1,8,86),(1,8,87),(1,8,89),(1,8,90),(1,8,91),(1,8,92),(1,8,93),(1,8,94),(1,8,95),(1,8,96),(1,8,97),
(1,1,1),(1,1,2),(1,1,4),(1,1,5),(1,1,6),(1,1,7),(1,1,8),(1,1,181),(1,1,182),(1,1,183),(1,1,185),
(1,12,135),(1,12,136),(1,12,137),(1,12,138),(1,12,140),(1,12,141),(1,12,142),(1,12,143),(1,12,144),(1,12,145),(1,12,146),
(1,13,76),(1,8,82),(1,8,88),(1,13,90),(1,13,93),(1,13,96),(1,13,147),(1,13,148),(1,13,149),(1,13,150),
(1,15,187),
(1,14,152),(1,14,153),(1,14,154),
(1,15,158),
(1,13,151),
(1,3,30),
(1,1,184),
(1,15,160);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Arc Thift Stores
(2,4,33),(2,4,34),(2,4,35),(2,4,36),(2,4,37),(2,4,38),(2,4,39),
(2,15,186),
(2,2,12),(2,2,13),(2,2,14),(2,2,15),(2,2,16),(2,2,17),
(2,9,116),
(2,1,3),(2,3,3),
(2,15,157),(2,15,159),
(2,8,79),
(2,8,81),
(2,3,1),(2,3,18),(2,3,19),(2,3,20),(2,3,21),(2,3,22),(2,3,23),(2,3,24),(2,3,25),(2,3,26),(2,3,27),(2,3,28),(2,3,29),(2,3,31),(2,3,32),(2,3,70),
(2,7,68),(2,7,69),(2,7,70),(2,7,71),(2,7,72),(2,7,73),(2,7,74),(2,7,75),
(2,13,82),(2,13,88),
(2,1,9),(2,15,9),
(2,1,11),
(2,10,117),(2,10,118),(2,10,120),(2,10,121),(2,10,122),(2,10,123),(2,10,124),(2,10,125),(2,10,126),(2,10,127),(2,10,128),(2,10,129),(2,10,130),
(2,10,119),
(2,8,76),(2,8,77),(2,8,78),(2,8,80),(2,8,82),(2,8,83),(2,8,84),(2,8,85),(2,8,86),(2,8,87),(2,8,88),(2,8,89),(2,8,90),(2,8,91),(2,8,92),(2,8,93),(2,8,94),(2,8,95),(2,8,96),(2,8,97),
(2,1,1),(2,1,2),(2,1,4),(2,1,5),(2,1,6),(2,1,7),(2,1,8),(2,1,181),(2,1,182),(2,1,183),(2,1,185),
(2,12,135),(2,12,136),(2,12,137),(2,12,138),(2,12,140),(2,12,141),(2,12,142),(2,12,143),(2,12,144),(2,12,145),(2,12,146),
(2,13,76),(2,13,90),(2,13,93),(2,13,96),(2,13,147),(2,13,148),(2,13,149),(2,13,150),(2,13,151),
(2,15,187),
(2,15,158),
(2,3,30),
(2,15,160);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Arc Thift Stores
(3,4,33),(3,4,34),(3,4,35),(3,4,36),(3,4,37),(3,4,38),(3,4,39),
(3,15,186),
(3,2,12),(3,2,13),(3,2,14),(3,2,15),(3,2,16),(3,2,17),
(3,9,116),
(3,1,3),(3,3,3),
(3,15,157),(3,15,159),
(3,8,79),
(3,8,81),
(3,3,1),(3,3,18),(3,3,19),(3,3,20),(3,3,21),(3,3,22),(3,3,23),(3,3,24),(3,3,25),(3,3,26),(3,3,27),(3,3,28),(3,3,29),(3,3,31),(3,3,32),(3,3,70),
(3,7,68),(3,7,69),(3,7,70),(3,7,71),(3,7,72),(3,7,73),(3,7,74),(3,7,75),
(3,13,82),(3,13,88),
(3,1,9),(3,15,9),
(3,1,11),
(3,10,117),(3,10,118),(3,10,120),(3,10,121),(3,10,122),(3,10,123),(3,10,124),(3,10,125),(3,10,126),(3,10,127),(3,10,128),(3,10,129),(3,10,130),
(3,10,119),
(3,8,76),(3,8,77),(3,8,78),(3,8,80),(3,8,82),(3,8,83),(3,8,84),(3,8,85),(3,8,86),(3,8,87),(3,8,88),(3,8,89),(3,8,90),(3,8,91),(3,8,92),(3,8,93),(3,8,94),(3,8,95),(3,8,96),(3,8,97),
(3,1,1),(3,1,2),(3,1,4),(3,1,5),(3,1,6),(3,1,7),(3,1,8),(3,1,181),(3,1,182),(3,1,183),(3,1,185),
(3,12,135),(3,12,136),(3,12,137),(3,12,138),(3,12,140),(3,12,141),(3,12,142),(3,12,143),(3,12,144),(3,12,145),(3,12,146),
(3,13,76),(3,13,90),(3,13,93),(3,13,96),(3,13,147),(3,13,148),(3,13,149),(3,13,150),(3,13,151),
(3,15,187),
(3,15,158),
(3,3,30),
(3,15,160);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Beekman
(4,1,11),
(4,1,1),(4,1,2),(4,1,4),(4,1,5),(4,1,6),(4,1,7),(4,1,8),(4,1,9),(4,1,10),(4,1,181),(4,1,182),(4,1,183),(4,1,185);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Benton County Extension
(5,15,186),
(5,1,9),(5,15,9),
(5,3,30);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Benton County Master Gardens
(6,1,3),(6,3,3),
(6,10,117),(6,10,118),(6,10,120),(6,10,121),(6,10,122),(6,10,123),(6,10,124),(6,10,125),(6,10,126),(6,10,127),(6,10,128),(6,10,129),(6,10,130),
(6,10,119);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Book Bin and Browser's
(7,1,3),(7,3,3), 
(7,8,79);


INSERT INTO business_category_item(bid,cid,iid) VALUES
#Boys & Girls Club
(9,15,186),
(9,15,157),(9,15,159),
(9,8,79),
(9,15,161),
(9,1,9),(9,15,9),
(9,10,117),(9,10,118),(9,10,120),(9,10,121),(9,10,122),(9,10,123),(9,10,124),(9,10,125),(9,10,126),(9,10,127),(9,10,128),(9,10,129),(9,10,130),
(9,10,119),
(9,15,187),
(9,3,30),
(9,1,184);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Buckingham Palace
(10,15,186),
(10,9,116),
(10,1,3),(10,3,3),
(10,15,157),(10,15,159),
(10,8,79),
(10,1,9),(10,15,9),
(10,1,11);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#CARDV
(12,4,33),(12,4,34),(12,4,35),(12,4,36),(12,4,37),(12,4,38),(12,4,39),
(12,1,3),(12,3,3),
(12,8,79),
(12,8,81),
(12,11,131),(12,11,133),(12,11,134),
(12,11,12),
(12,8,76),(12,8,77),(12,8,78),(12,8,80),(12,8,82),(12,8,83),(12,8,84),(12,8,85),(12,8,86),(12,8,87),(12,8,88),(12,8,89),(12,8,90),(12,8,91),(12,8,92),(12,8,93),(12,8,94),(12,8,95),(12,8,96),(12,8,97),
(12,1,1),(12,1,2),(12,1,4),(12,1,5),(12,1,6),(12,1,7),(12,1,8),(12,1,9),(12,1,10),(12,1,11),(12,1,181),(12,1,182),(12,1,183),(12,1,184),(12,1,185);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Career Closet for Women
(13,7,68),(13,7,69),(13,7,70),(13,7,71),(13,7,72),(13,7,73),(13,7,74),(13,7,75);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Cat's Meow
(14,4,33),(14,4,34),(14,4,35),(14,4,36),(14,4,37),(14,4,38),(14,4,39),
(14,15,186),
(14,2,12),(14,2,13),(14,2,14),(14,2,15),(14,2,16),(14,2,17),
(14,9,116),
(14,1,3),(14,3,3),
(14,15,157),(14,15,159),
(14,8,79),
(14,8,81),
(14,3,1),(14,3,18),(14,3,19),(14,3,20),(14,3,21),(14,3,22),(14,3,23),(14,3,24),(14,3,25),(14,3,26),(14,3,27),(14,3,28),(14,3,29),(14,3,31),(14,3,32),(14,3,70),
(14,7,68),(14,7,69),(14,7,70),(14,7,71),(14,7,72),(14,7,73),(14,7,74),(14,7,75),
(14,12,139),
(14,1,9),(14,15,9),
(14,1,11),
(14,10,117),(14,10,118),(14,10,120),(14,10,121),(14,10,122),(14,10,123),(14,10,124),(14,10,125),(14,10,126),(14,10,127),(14,10,128),(14,10,129),(14,10,130),
(14,8,76),(14,8,77),(14,8,78),(14,8,80),(14,8,82),(14,8,83),(14,8,84),(14,8,85),(14,8,86),(14,8,87),(14,8,88),(14,8,89),(14,8,90),(14,8,91),(14,8,92),(14,8,93),(14,8,94),(14,8,95),(14,8,96),(14,8,97),
(14,1,1),(14,1,2),(14,1,4),(14,1,5),(14,1,6),(14,1,7),(14,1,8),(14,1,181),(14,1,182),(14,1,183),(14,1,185),
(14,12,135),(14,12,136),(14,12,137),(14,12,138),(14,12,140),(14,12,141),(14,12,142),(14,12,143),(14,12,144),(14,12,145),(14,12,146),
(14,13,76),(14,13,90),(14,13,93),(14,13,96),(14,13,147),(14,13,148),(14,13,149),(14,13,150),(14,13,151),
(14,15,187),
(14,15,158),
(14,3,30),
(14,1,184);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Children's Farm Home
(15,4,33),(15,4,34),(15,4,35),(15,4,36),(15,4,37),(15,4,38),(15,4,39),
(15,15,186),
(15,9,116),
(15,6,45),(15,6,46),(15,6,47),(15,6,48),(15,6,49),(15,6,50),(15,6,51),(15,6,52),(15,6,53),(15,6,54),(15,6,55),(15,6,56),(15,6,57),(15,6,58),(15,6,59),(15,6,60),(15,6,61),(15,6,62),(15,6,63),(15,6,64),(15,6,65),(15,6,66),(15,6,67),
(15,8,79),
(15,3,1),(15,3,18),(15,3,19),(15,3,20),(15,3,21),(15,3,22),(15,3,23),(15,3,24),(15,3,25),(15,3,26),(15,3,27),(15,3,28),(15,3,29),(15,3,31),(15,3,32),(15,3,70),
(15,7,68),(15,7,69),(15,7,70),(15,7,71),(15,7,72),(15,7,73),(15,7,74),(15,7,75),
(15,1,11),
(15,10,117),(15,10,118),(15,10,120),(15,10,121),(15,10,122),(15,10,123),(15,10,124),(15,10,125),(15,10,126),(15,10,127),(15,10,128),(15,10,129),(15,10,130),
(15,8,76),(15,8,77),(15,8,78),(15,8,80),(15,8,82),(15,8,83),(15,8,84),(15,8,85),(15,8,86),(15,8,87),(15,8,88),(15,8,89),(15,8,90),(15,8,91),(15,8,92),(15,8,93),(15,8,94),(15,8,95),(15,8,96),(15,8,97),
(15,15,187),
(15,3,30),
(15,1,184);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Chintimini
(16,2,12),(16,2,13),(16,2,14),(16,2,15),(16,2,16),(16,2,17),
(16,6,45),(16,6,46),(16,6,47),(16,6,48),(16,6,49),(16,6,50),(16,6,51),(16,6,52),(16,6,53),(16,6,54),(16,6,55),(16,6,56),(16,6,57),(16,6,58),(16,6,59),(16,6,60),(16,6,61),(16,6,62),(16,6,63),(16,6,64),(16,6,65),(16,6,66),(16,6,67),
(16,11,12),
(16,10,117),(16,10,118),(16,10,120),(16,10,121),(16,10,122),(16,10,123),(16,10,124),(16,10,125),(16,10,126),(16,10,127),(16,10,128),(16,10,129),(16,10,130),
(16,12,135),(16,12,136),(16,12,137),(16,12,138),(16,12,140),(16,12,141),(16,12,142),(16,12,143),(16,12,144),(16,12,145),(16,12,146),
(16,15,158);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Community Outreach
(17,15,186),
(17,2,12),(17,2,13),(17,2,14),(17,2,15),(17,2,16),(17,2,17),
(17,11,131),(17,11,133),(17,11,134),
(17,11,12),
(17,3,30),
(17,1,184);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Corvallis Environmental
(18,15,186),
(18,15,161),
(18,10,119),
(18,13,76),(18,13,90),(18,13,93),(18,13,96),(18,13,147),(18,13,148),(18,13,149),(18,13,150),
(18,3,30);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Corvallis Bicycle Collective
(19,9,116);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Corvallis-Uzhhorod Sister Cities
(21,12,135),(21,12,136),(21,12,137),(21,12,138),(21,12,140),(21,12,141),(21,12,142),(21,12,143),(21,12,144),(21,12,145),(21,12,146);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Cosmic Chameleon
(22,15,157),(22,15,159),
(22,3,1),(22,3,18),(22,3,19),(22,3,20),(22,3,21),(22,3,22),(22,3,23),(22,3,24),(22,3,25),(22,3,26),(22,3,27),(22,3,28),(22,3,29),(22,3,31),(22,3,32),(22,3,70),
(22,7,68),(22,7,69),(22,7,70),(22,7,71),(22,7,72),(22,7,73),(22,7,74),(22,7,75);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Craigslist
(23,5,40),(23,5,41),(23,5,42),(23,5,43),(23,5,44),
(23,4,33),(23,4,34),(23,4,35),(23,4,36),(23,4,37),(23,4,38),(23,4,39),
(23,15,186),
(23,2,12),(23,2,13),(23,2,14),(23,2,15),(23,2,16),(23,2,17),
(23,9,116),
(23,1,3),(23,3,3),
(23,15,157),(23,15,159),
(23,6,45),(23,6,46),(23,6,47),(23,6,48),(23,6,49),(23,6,50),(23,6,51),(23,6,52),(23,6,53),(23,6,54),(23,6,55),(23,6,56),(23,6,57),(23,6,58),(23,6,59),(23,6,60),(23,6,61),(23,6,62),(23,6,63),(23,6,64),(23,6,65),(23,6,66),(23,6,67),
(23,8,79),
(23,8,81),
(23,3,1),(23,3,18),(23,3,19),(23,3,20),(23,3,21),(23,3,22),(23,3,23),(23,3,24),(23,3,25),(23,3,26),(23,3,27),(23,3,28),(23,3,29),(23,3,31),(23,3,32),(23,3,70),
(23,7,68),(23,7,69),(23,7,70),(23,7,71),(23,7,72),(23,7,73),(23,7,74),(23,7,75),
(23,15,161),
(23,13,82),(23,13,88),
(23,15,155),
(23,12,139),
(23,1,9),(23,15,9),
(23,15,156),
(23,11,131),(23,11,133),(23,11,134),
(23,11,12),
(23,1,10),
(23,1,11),
(23,10,117),(23,10,118),(23,10,120),(23,10,121),(23,10,122),(23,10,123),(23,10,124),(23,10,125),(23,10,126),(23,10,127),(23,10,128),(23,10,129),(23,10,130),
(23,10,119),
(23,8,76),(23,8,77),(23,8,78),(23,8,80),(23,8,82),(23,8,83),(23,8,84),(23,8,85),(23,8,86),(23,8,87),(23,8,88),(23,8,89),(23,8,90),(23,8,91),(23,8,92),(23,8,93),(23,8,94),(23,8,95),(23,8,96),(23,8,97),
(23,1,1),(23,1,2),(23,1,4),(23,1,5),(23,1,6),(23,1,7),(23,1,8),(23,1,181),(23,1,182),(23,1,183),(23,1,185),
(23,12,135),(23,12,136),(23,12,137),(23,12,138),(23,12,140),(23,12,141),(23,12,142),(23,12,143),(23,12,144),(23,12,145),(23,12,146),
(23,13,76),(23,13,90),(23,13,93),(23,13,96),(23,13,147),(23,13,148),(23,13,149),(23,13,150),
(23,15,187),
(23,14,152),(23,14,153),(23,14,154),
(23,15,158),
(23,3,30),
(23,1,184),
(23,15,160);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#First Alternative Co-op
(24,5,40),(24,5,41),(24,5,42),(24,5,43),(24,5,44),
(24,4,33),(24,4,34),(24,4,35),(24,4,36),(24,4,37),(24,4,38),(24,4,39),
(24,10,119),
(24,14,152),(24,14,153),(24,14,154);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#First Alternative Co-op Stores (NW)
(25,15,157),(25,15,159),
(25,15,155),
(25,12,139),
(25,11,131),(25,11,133),(25,11,134),
(25,1,10),
(25,13,151);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#First Alternative Co-op Stores (SE)
(26,15,157),(26,15,159),
(26,15,155),
(26,12,139),
(26,11,131),(26,11,133),(26,11,134),
(26,1,10),
(26,13,151);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Furniture Exchange
(27,1,11),
(27,1,1),(27,1,2),(27,1,4),(27,1,5),(27,1,6),(27,1,7),(27,1,8),(27,1,181),(27,1,182),(27,1,183),(27,1,185);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Furniture Share
(28,5,40),(28,5,41),(28,5,42),(28,5,43),(28,5,44),
(28,4,33),(28,4,34),(28,4,35),(28,4,36),(28,4,37),(28,4,38),(28,4,39),
(28,2,12),(28,2,13),(28,2,14),(28,2,15),(28,2,16),(28,2,17),
(28,1,11),
(28,8,76),(28,8,77),(28,8,78),(28,8,80),(28,8,82),(28,8,83),(28,8,84),(28,8,85),(28,8,86),(28,8,87),(28,8,88),(28,8,89),(28,8,90),(28,8,91),(28,8,92),(28,8,93),(28,8,94),(28,8,95),(28,8,96),(28,8,97),
(28,1,1),(28,1,2),(28,1,4),(28,1,5),(28,1,6),(28,1,7),(28,1,8),(28,1,181),(28,1,182),(28,1,183),(28,1,185);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Garland Nursery
(29,10,119);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Goodwill Industries
(30,5,40),(30,5,41),(30,5,42),(30,5,43),(30,5,44),
(30,4,33),(30,4,34),(30,4,35),(30,4,36),(30,4,37),(30,4,38),(30,4,39),
(30,15,186),
(30,2,12),(30,2,13),(30,2,14),(30,2,15),(30,2,16),(30,2,17),
(30,9,116),
(30,1,3),(30,3,3),
(30,6,45),(30,6,46),(30,6,47),(30,6,48),(30,6,49),(30,6,50),(30,6,51),(30,6,52),(30,6,53),(30,6,54),(30,6,55),(30,6,56),(30,6,57),(30,6,58),(30,6,59),(30,6,60),(30,6,61),(30,6,62),(30,6,63),(30,6,64),(30,6,65),(30,6,66),(30,6,67),
(30,8,79),
(30,3,1),(30,3,18),(30,3,19),(30,3,20),(30,3,21),(30,3,22),(30,3,23),(30,3,24),(30,3,25),(30,3,26),(30,3,27),(30,3,28),(30,3,29),(30,3,31),(30,3,32),(30,3,70),
(30,7,68),(30,7,69),(30,7,70),(30,7,71),(30,7,72),(30,7,73),(30,7,74),(30,7,75),
(30,13,82),(30,13,88),
(30,12,139),
(30,1,9),(30,15,9),
(30,1,11),
(30,10,117),(30,10,118),(30,10,120),(30,10,121),(30,10,122),(30,10,123),(30,10,124),(30,10,125),(30,10,126),(30,10,127),(30,10,128),(30,10,129),(30,10,130),
(30,10,119),
(30,8,76),(30,8,77),(30,8,78),(30,8,80),(30,8,82),(30,8,83),(30,8,84),(30,8,85),(30,8,86),(30,8,87),(30,8,88),(30,8,89),(30,8,90),(30,8,91),(30,8,92),(30,8,93),(30,8,94),(30,8,95),(30,8,96),(30,8,97),
(30,1,1),(30,1,2),(30,1,4),(30,1,5),(30,1,6),(30,1,7),(30,1,8),(30,1,181),(30,1,182),(30,1,183),(30,1,185),
(30,12,135),(30,12,136),(30,12,137),(30,12,138),(30,12,140),(30,12,141),(30,12,142),(30,12,143),(30,12,144),(30,12,145),(30,12,146),
(30,13,76),(30,13,90),(30,13,93),(30,13,96),(30,13,147),(30,13,148),(30,13,149),(30,13,150),
(30,15,187),
(30,15,158),
(30,3,30),
(30,1,184),
(30,15,160);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Habitat for Humanity ReStore
(32,5,40),(32,5,41),(32,5,42),(32,5,43),(32,5,44),
(32,4,33),(32,4,34),(32,4,35),(32,4,36),(32,4,37),(32,4,38),(32,4,39),
(32,15,186),
(32,9,116),
(32,15,157),(32,15,159),
(32,6,45),(32,6,46),(32,6,47),(32,6,48),(32,6,49),(32,6,50),(32,6,51),(32,6,52),(32,6,53),(32,6,54),(32,6,55),(32,6,56),(32,6,57),(32,6,58),(32,6,59),(32,6,60),(32,6,61),(32,6,62),(32,6,63),(32,6,64),(32,6,65),(32,6,66),(32,6,67),
(32,8,79),
(32,13,82),(32,13,88),
(32,15,156),
(32,1,11),
(32,10,117),(32,10,118),(32,10,120),(32,10,121),(32,10,122),(32,10,123),(32,10,124),(32,10,125),(32,10,126),(32,10,127),(32,10,128),(32,10,129),(32,10,130),
(32,10,119),
(32,8,76),(32,8,77),(32,8,78),(32,8,80),(32,8,82),(32,8,83),(32,8,84),(32,8,85),(32,8,86),(32,8,87),(32,8,88),(32,8,89),(32,8,90),(32,8,91),(32,8,92),(32,8,93),(32,8,94),(32,8,95),(32,8,96),(32,8,97),
(32,1,1),(32,1,2),(32,1,4),(32,1,5),(32,1,6),(32,1,7),(32,1,8),(32,1,181),(32,1,182),(32,1,183),(32,1,185),
(32,12,135),(32,12,136),(32,12,137),(32,12,138),(32,12,140),(32,12,141),(32,12,142),(32,12,143),(32,12,144),(32,12,145),(32,12,146),
(32,13,76),(32,13,90),(32,13,93),(32,13,96),(32,13,147),(32,13,148),(32,13,149),(32,13,150),
(32,15,187);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Happy Trails Records
(33,8,79);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Heartland Humane
(34,2,12),(34,2,13),(34,2,14),(34,2,15),(34,2,16),(34,2,17),
(34,15,158);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Home Life Inc.
(35,15,186),
(35,2,12),(35,2,13),(35,2,14),(35,2,15),(35,2,16),(35,2,17),
(35,1,3),(35,3,3),
(35,8,79),
(35,7,68),(35,7,69),(35,7,70),(35,7,71),(35,7,72),(35,7,73),(35,7,74),(35,7,75),
(35,1,11),
(35,10,117),(35,10,118),(35,10,120),(35,10,121),(35,10,122),(35,10,123),(35,10,124),(35,10,125),(35,10,126),(35,10,127),(35,10,128),(35,10,129),(35,10,130),
(35,10,119),
(35,8,76),(35,8,77),(35,8,78),(35,8,80),(35,8,82),(35,8,83),(35,8,84),(35,8,85),(35,8,86),(35,8,87),(35,8,88),(35,8,89),(35,8,90),(35,8,91),(35,8,92),(35,8,93),(35,8,94),(35,8,95),(35,8,96),(35,8,97),
(35,1,1),(35,1,2),(35,1,4),(35,1,5),(35,1,6),(35,1,7),(35,1,8),(35,1,181),(35,1,182),(35,1,183),(35,1,185),
(35,13,76),(35,13,90),(35,13,93),(35,13,96),(35,13,147),(35,13,148),(35,13,149),(35,13,150),
(35,15,187),
(35,1,184),
(35,15,160);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Jackson Street Youth Shelter
(36,15,186),
(36,2,12),(36,2,13),(36,2,14),(36,2,15),(36,2,16),(36,2,17),
(36,9,116),
(36,6,45),(36,6,46),(36,6,47),(36,6,48),(36,6,49),(36,6,50),(36,6,51),(36,6,52),(36,6,53),(36,6,54),(36,6,55),(36,6,56),(36,6,57),(36,6,58),(36,6,59),(36,6,60),(36,6,61),(36,6,62),(36,6,63),(36,6,64),(36,6,65),(36,6,66),(36,6,67),
(36,8,79),
(36,11,12),
(36,10,117),(36,10,118),(36,10,120),(36,10,121),(36,10,122),(36,10,123),(36,10,124),(36,10,125),(36,10,126),(36,10,127),(36,10,128),(36,10,129),(36,10,130),
(36,15,187),
(36,3,30),
(36,1,184);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Linn Benton
(37,11,131),(37,11,133),(37,11,134);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Lions Club
(38,12,139);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Love INC
(39,5,40),(39,5,41),(39,5,42),(39,5,43),(39,5,44),
(39,4,33),(39,4,34),(39,4,35),(39,4,36),(39,4,37),(39,4,38),(39,4,39),
(39,15,186),
(39,2,12),(39,2,13),(39,2,14),(39,2,15),(39,2,16),(39,2,17),
(39,9,116),
(39,8,81),
(39,3,1),(39,3,18),(39,3,19),(39,3,20),(39,3,21),(39,3,22),(39,3,23),(39,3,24),(39,3,25),(39,3,26),(39,3,27),(39,3,28),(39,3,29),(39,3,31),(39,3,32),(39,3,70),
(39,13,82),(39,13,88),
(39,12,139),
(39,1,9),(39,15,9),
(39,15,156),
(39,11,131),(39,11,133),(39,11,134),
(39,1,11),
(39,10,117),(39,10,118),(39,10,120),(39,10,121),(39,10,122),(39,10,123),(39,10,124),(39,10,125),(39,10,126),(39,10,127),(39,10,128),(39,10,129),(39,10,130),
(39,8,76),(39,8,77),(39,8,78),(39,8,80),(39,8,82),(39,8,83),(39,8,84),(39,8,85),(39,8,86),(39,8,87),(39,8,88),(39,8,89),(39,8,90),(39,8,91),(39,8,92),(39,8,93),(39,8,94),(39,8,95),(39,8,96),(39,8,97),
(39,1,1),(39,1,2),(39,1,4),(39,1,5),(39,1,6),(39,1,7),(39,1,8),(39,1,181),(39,1,182),(39,1,183),(39,1,185),
(39,12,135),(39,12,136),(39,12,137),(39,12,138),(39,12,140),(39,12,141),(39,12,142),(39,12,143),(39,12,144),(39,12,145),(39,12,146),
(39,15,187),
(39,15,158),
(39,3,30),
(39,1,184),
(39,15,160);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Mario Pastega
(40,1,3),(40,3,3),
(40,8,79),
(40,11,131),(40,11,133),(40,11,134);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Mary's River Gleaners
(41,5,40),(41,5,41),(41,5,42),(41,5,43),(41,5,44),
(41,4,33),(41,4,34),(41,4,35),(41,4,36),(41,4,37),(41,4,38),(41,4,39),
(41,15,186),
(41,2,12),(41,2,13),(41,2,14),(41,2,15),(41,2,16),(41,2,17),
(41,9,116),
(41,1,3),(41,3,3),
(41,15,157),(41,15,159),
(41,8,79),
(41,8,81),
(41,3,1),(41,3,18),(41,3,19),(41,3,20),(41,3,21),(41,3,22),(41,3,23),(41,3,24),(41,3,25),(41,3,26),(41,3,27),(41,3,28),(41,3,29),(41,3,31),(41,3,32),(41,3,70),
(41,7,68),(41,7,69),(41,7,70),(41,7,71),(41,7,72),(41,7,73),(41,7,74),(41,7,75),
(41,1,9),(41,15,9),
(41,15,156),
(41,11,131),(41,11,133),(41,11,134),
(41,11,12),
(41,1,11),
(41,10,117),(41,10,118),(41,10,120),(41,10,121),(41,10,122),(41,10,123),(41,10,124),(41,10,125),(41,10,126),(41,10,127),(41,10,128),(41,10,129),(41,10,130),
(41,10,119),
(41,8,76),(41,8,77),(41,8,78),(41,8,80),(41,8,82),(41,8,83),(41,8,84),(41,8,85),(41,8,86),(41,8,87),(41,8,88),(41,8,89),(41,8,90),(41,8,91),(41,8,92),(41,8,93),(41,8,94),(41,8,95),(41,8,96),(41,8,97),
(41,1,1),(41,1,2),(41,1,4),(41,1,5),(41,1,6),(41,1,7),(41,1,8),(41,1,181),(41,1,182),(41,1,183),(41,1,185),
(41,12,135),(41,12,136),(41,12,137),(41,12,138),(41,12,140),(41,12,141),(41,12,142),(41,12,143),(41,12,144),(41,12,145),(41,12,146),
(41,15,187),
(41,15,158),
(41,3,30),
(41,1,184),
(41,15,160);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Midway Farms
(42,15,157),(42,15,159),
(42,15,155);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Neighbor to Neighbor
(43,11,131),(43,11,133),(43,11,134),
(43,11,12);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Osborn Aquatic
(44,5,40),(44,5,41),(44,5,42),(44,5,43),(44,5,44);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#OSU Emergency Food Pantry
(45,11,131),(45,11,133),(45,11,134),
(45,11,12),
(45,1,184);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#OSU Folk Club Thrift Shop
(46,4,33),(46,4,34),(46,4,35),(46,4,36),(46,4,37),(46,4,38),(46,4,39),
(46,15,186),
(46,2,12),(46,2,13),(46,2,14),(46,2,15),(46,2,16),(46,2,17),
(46,9,116),
(46,1,3),(46,3,3),
(46,15,157),(46,15,159),
(46,8,79),
(46,3,1),(46,3,18),(46,3,19),(46,3,20),(46,3,21),(46,3,22),(46,3,23),(46,3,24),(46,3,25),(46,3,26),(46,3,27),(46,3,28),(46,3,29),(46,3,31),(46,3,32),(46,3,70),
(46,7,68),(46,7,69),(46,7,70),(46,7,71),(46,7,72),(46,7,73),(46,7,74),(46,7,75),
(46,12,139),
(46,1,9),(46,15,9),
(46,10,117),(46,10,118),(46,10,120),(46,10,121),(46,10,122),(46,10,123),(46,10,124),(46,10,125),(46,10,126),(46,10,127),(46,10,128),(46,10,129),(46,10,130),
(46,10,119),
(46,1,1),(46,1,2),(46,1,4),(46,1,5),(46,1,6),(46,1,7),(46,1,8),(46,1,181),(46,1,182),(46,1,183),(46,1,185),
(46,12,135),(46,12,136),(46,12,137),(46,12,138),(46,12,140),(46,12,141),(46,12,142),(46,12,143),(46,12,144),(46,12,145),(46,12,146),
(46,15,187),
(46,15,158),
(46,3,30);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#OSU Organic Growers
(47,10,117),(47,10,118),(47,10,120),(47,10,121),(47,10,122),(47,10,123),(47,10,124),(47,10,125),(47,10,126),(47,10,127),(47,10,128),(47,10,129),(47,10,130);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Pak Mail
(48,14,152),(48,14,153),(48,14,154);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Parent Enhancement Program
(49,15,186),
(49,9,116),
(49,1,3),(49,3,3),
(49,15,157),(49,15,159),
(49,3,1),(49,3,18),(49,3,19),(49,3,20),(49,3,21),(49,3,22),(49,3,23),(49,3,24),(49,3,25),(49,3,26),(49,3,27),(49,3,28),(49,3,29),(49,3,31),(49,3,32),(49,3,70),
(49,7,68),(49,7,69),(49,7,70),(49,7,71),(49,7,72),(49,7,73),(49,7,74),(49,7,75),
(49,1,9),(49,15,9),
(49,11,131),(49,11,133),(49,11,134),
(49,15,187),
(49,3,30),
(49,1,184);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Pastors for Peace-Caravan to Cuba
(50,9,116),
(50,13,82),(50,13,88),
(50,12,135),(50,12,136),(50,12,137),(50,12,138),(50,12,140),(50,12,141),(50,12,142),(50,12,143),(50,12,144),(50,12,145),(50,12,146);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Philomath Community Garden
(51,10,117),(51,10,118),(51,10,120),(51,10,121),(51,10,122),(51,10,123),(51,10,124),(51,10,125),(51,10,126),(51,10,127),(51,10,128),(51,10,129),(51,10,130);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Philomath Community Srvcs
(52,1,3),(52,3,3),
(52,3,1),(52,3,18),(52,3,19),(52,3,20),(52,3,21),(52,3,22),(52,3,23),(52,3,24),(52,3,25),(52,3,26),(52,3,27),(52,3,28),(52,3,29),(52,3,31),(52,3,32),(52,3,70),
(52,15,156),
(52,11,131),(52,11,133),(52,11,134),
(52,11,12);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Play It Again Sports
(53,9,116);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Presbyterian Piecemakers
(54,1,9),(54,15,9);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Public Library Corvallis
(55,1,3),(55,3,3),
(55,8,79);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Quilts from Caring Hands
(56,1,9),(56,15,9);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Rapid Refill Ink
(57,13,151);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Replay Children's Wear
(58,3,1),(58,3,18),(58,3,19),(58,3,20),(58,3,21),(58,3,22),(58,3,23),(58,3,24),(58,3,25),(58,3,26),(58,3,27),(58,3,28),(58,3,29),(58,3,31),(58,3,32),(58,3,70);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#revolve
(59,15,157),(59,15,159),
(59,7,68),(59,7,69),(59,7,70),(59,7,71),(59,7,72),(59,7,73),(59,7,74),(59,7,75);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Schools--public, private, charter 
(60,15,186),
(60,1,3),(60,3,3),
(60,15,187),
(60,3,30);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Second Glance
(61,15,157),(61,15,159),
(61,7,68),(61,7,69),(61,7,70),(61,7,71),(61,7,72),(61,7,73),(61,7,74),(61,7,75);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Senior Center of Corvallis
(64,8,79),
(64,8,81),
(64,12,139),
(64,11,12),
(64,12,135),(64,12,136),(64,12,137),(64,12,138),(64,12,140),(64,12,141),(64,12,142),(64,12,143),(64,12,144),(64,12,145),(64,12,146);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#South Corvallis Food Bank
(65,11,131),(65,11,133),(65,11,134),
(65,11,12);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Stone Soup & St Vincent de Paul
(67,4,33),(67,4,34),(67,4,35),(67,4,36),(67,4,37),(67,4,38),(67,4,39),
(67,15,186),
(67,15,157),(67,15,159),
(67,8,79),
(67,3,1),(67,3,18),(67,3,19),(67,3,20),(67,3,21),(67,3,22),(67,3,23),(67,3,24),(67,3,25),(67,3,26),(67,3,27),(67,3,28),(67,3,29),(67,3,31),(67,3,32),(67,3,70),
(67,7,68),(67,7,69),(67,7,70),(67,7,71),(67,7,72),(67,7,73),(67,7,74),(67,7,75),
(67,11,131),(67,11,133),(67,11,134),
(67,11,12),
(67,1,1),(67,1,2),(67,1,4),(67,1,5),(67,1,6),(67,1,7),(67,1,8),(67,1,181),(67,1,182),(67,1,183),(67,1,185),
(67,13,76),(67,8,82),(67,8,88),(67,13,90),(67,13,93),(67,13,96),(67,13,147),(67,13,148),(67,13,149),(67,13,150),
(67,15,158),
(67,3,30),
(67,1,184);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#UPS Stores NW
(68,14,152),(68,14,153),(68,14,154);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#UPS Stores SW
(69,14,152),(69,14,153),(69,14,154);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Vina Moses
(70,4,33),(70,4,34),(70,4,35),(70,4,36),(70,4,37),(70,4,38),(70,4,39),
(70,15,186),
(70,2,12),(70,2,13),(70,2,14),(70,2,15),(70,2,16),(70,2,17),
(70,9,116),
(70,1,3),(70,3,3),
(70,15,157),(70,15,159),
(70,8,79),
(70,3,1),(70,3,18),(70,3,19),(70,3,20),(70,3,21),(70,3,22),(70,3,23),(70,3,24),(70,3,25),(70,3,26),(70,3,27),(70,3,28),(70,3,29),(70,3,31),(70,3,32),(70,3,70),
(70,7,68),(70,7,69),(70,7,70),(70,7,71),(70,7,72),(70,7,73),(70,7,74),(70,7,75),
(70,12,139),
(70,1,9),(70,15,9),
(70,11,131),(70,11,133),(70,11,134),
(70,11,12),
(70,10,117),(70,10,118),(70,10,120),(70,10,121),(70,10,122),(70,10,123),(70,10,124),(70,10,125),(70,10,126),(70,10,127),(70,10,128),(70,10,129),(70,10,130),
(70,10,119),
(70,8,76),(70,8,77),(70,8,78),(70,8,80),(70,8,83),(70,8,84),(70,8,85),(70,8,86),(70,8,87),(70,8,89),(70,8,90),(70,8,91),(70,8,92),(70,8,93),(70,8,94),(70,8,95),(70,8,96),(70,8,97),
(70,1,1),(70,1,2),(70,1,4),(70,1,5),(70,1,6),(70,1,7),(70,1,8),(70,1,181),(70,1,182),(70,1,183),(70,1,185),
(70,15,187),
(70,15,158),
(70,3,30),
(70,1,184);

INSERT INTO business_category_item(bid,cid,iid) VALUES
#Spaeth Heritage House
(71,6,45),(71,6,46),(71,6,47),(71,6,48),(71,6,49),(71,6,50),(71,6,51),(71,6,52),(71,6,53),(71,6,54),(71,6,55),(71,6,56),(71,6,57),(71,6,58),(71,6,59),(71,6,60),(71,6,61),(71,6,62),(71,6,63),(71,6,64),(71,6,65),(71,6,66),(71,6,67),
(71,1,11),
(71,10,117),(71,10,118),(71,10,120),(71,10,121),(71,10,122),(71,10,123),(71,10,124),(71,10,125),(71,10,126),(71,10,127),(71,10,128),(71,10,129),(71,10,130),
(71,10,119),
(71,1,1),(71,1,2),(71,1,4),(71,1,5),(71,1,6),(71,1,7),(71,1,8),(71,1,181),(71,1,182),(71,1,183),(71,1,185);









