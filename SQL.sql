CREATE TABLE RESTAURANT (
    name	VARCHAR(70),
    description	VARCHAR(200)	NOT NULL,
    isActive	BOOLEAN	NOT NULL,
    id	INTEGER	NOT NULL,
    fK1_menu_id	INTEGER,
PRIMARY KEY (id) );

CREATE TABLE Coupon (
    code	VARCHAR(12)	NOT NULL,
    name	VARCHAR(100)	NOT NULL,
    discount	DECIMAL(10,2),
    isRelativeDiscount	BOOLEAN	NOT NULL,
    maximumUses	INTEGER	NOT NULL,
    id	INTEGER	NOT NULL,
    FK1_id	INTEGER,
PRIMARY KEY (id) );

CREATE TABLE SUSHI (
    id	INTEGER	NOT NULL,
PRIMARY KEY (id) );

CREATE TABLE ITALIAN (
    id	INTEGER	NOT NULL,
PRIMARY KEY (id) );

CREATE TABLE CHINESE (
    id	INTEGER	NOT NULL,
PRIMARY KEY (id) );

CREATE TABLE VEGAN (
    id	INTEGER	NOT NULL,
PRIMARY KEY (id) );

CREATE TABLE Mexican (
    id	INTEGER	NOT NULL,
PRIMARY KEY (id) );

CREATE TABLE MENU (
    name	VARCHAR(100)	NOT NULL,
    menu_id	INTEGER	NOT NULL,
PRIMARY KEY (menu_id) );

CREATE TABLE MENU_ITEM (
    name	VARCHAR(100),
    description	VARCHAR(1000)	NOT NULL,
    price	DECIMAL(10,2)	NOT NULL,
    menu_item_id	INTEGER	NOT NULL,
    fk1_menu_id	INTEGER	NOT NULL,
PRIMARY KEY (menu_item_id) );

CREATE TABLE ORDERS (
    cost	DECIMAL(10,2)	NOT NULL,
    isPaid	BOOLEAN	NOT NULL,
    order_date	DATE	NOT NULL,
    order_time	TIME	NOT NULL,
    order_id	INTEGER	NOT NULL,
    FK1_id	INTEGER	NOT NULL,
    FK2_status_id	INTEGER,
    FK3_id	INTEGER	NOT NULL,
    FK4_customer_id	INTEGER,
PRIMARY KEY (order_id) );

CREATE TABLE OrderStatus (
    name	VARCHAR(20),
    status_id	INTEGER	NOT NULL,
PRIMARY KEY (status_id) );

CREATE TABLE CUSTOMER (
    lastName	VARCHAR(70)	NOT NULL,
    firstName	VARCHAR(70)	NOT NULL,
    email	VARCHAR(140)	NOT NULL,
    address	CHAR(200)	NOT NULL,
    password	VARCHAR(70),
    customer_id	INTEGER	NOT NULL,
PRIMARY KEY (customer_id) );

CREATE TABLE TAKE_AWAY (
    preparation_time	INTEGER,
    customer_id	INTEGER	NOT NULL,
PRIMARY KEY (customer_id) );

CREATE TABLE DELIVERY (
    customer_id	INTEGER	NOT NULL,
PRIMARY KEY (customer_id) );

CREATE TABLE EMPLOYEES (
    firstName	VARCHAR(70)	NOT NULL,
    lastName	VARCHAR(70)	NOT NULL,
    salary	DECIMAL(10,2)	NOT NULL,
    social_security	INTEGER	NOT NULL,
    employee_id	INTEGER	NOT NULL,
    FK1_id	INTEGER	NOT NULL,
PRIMARY KEY (employee_id) );

CREATE TABLE Cashier (
    employee_id	INTEGER	NOT NULL,
PRIMARY KEY (employee_id) );

CREATE TABLE Cook (
    employee_id	INTEGER	NOT NULL,
PRIMARY KEY (employee_id) );

CREATE TABLE DeliveryBoy (
    employee_id	INTEGER	NOT NULL,
PRIMARY KEY (employee_id) );

CREATE TABLE OrderItem (
    quantity	INTEGER	NOT NULL,
    item_id	INTEGER	NOT NULL,
    FK1_order_id	INTEGER	NOT NULL,
PRIMARY KEY (item_id, FK1_order_id) );

CREATE TABLE Handles (
    FK1_employee_id	INTEGER	NOT NULL,
    FK2_order_id	INTEGER	NOT NULL,
PRIMARY KEY (FK1_employee_id, FK2_order_id) );

CREATE TABLE COOKS (
    FK1_employee_id	INTEGER	NOT NULL,
    FK2_menu_item_id	INTEGER	NOT NULL,
PRIMARY KEY (FK1_employee_id, FK2_menu_item_id) );

