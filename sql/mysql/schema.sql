CREATE TABLE IF NOT EXISTS jaj_newsletter_subscription_list (
    id int(11) NOT NULL auto_increment,
    created int(11) NOT NULL default '0',
    creator_id int(11) NOT NULL default '0',
    modified int(11) NOT NULL default '0',
  	modifier_id int(11) NOT NULL default '0',
    name varchar(45) NOT NULL DEFAULT '',
    description longtext,
    PRIMARY KEY  (id)
)  ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS jaj_newsletter_subscription (
    uuid CHAR(32) BINARY NOT NULL,
    subscription_list_id int(11) NOT NULL,
    
    created int(11) NOT NULL default '0',
    creator_id int(11) NOT NULL default '0',
    modified int(11) NOT NULL default '0',
  	modifier_id int(11) NOT NULL default '0',
  		
    name varchar(100) NOT NULL DEFAULT '',
    email varchar(150) NOT NULL DEFAULT '',
    state varchar(12) NOT NULL DEFAULT '',
    bounce_count int(11) NOT NULL default '0',
    	
    subscribed int(11) NOT NULL default '0',
    confirmed int(11) NOT NULL default '0',    	
    unsubscribed int(11) NOT NULL default '0',    
    bounced int(11) NOT NULL default '0',    
    deleted int(11) NOT NULL default '0',
    
    #subscribed_ip	varchar(15) NOT NULL default '',
    #subscribed_address varchar(255) NOT NULL default '',
    
    PRIMARY KEY  (uuid)
)  ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS jaj_newsletter_recipients_list (
    contentobject_id int(11) NOT NULL default '0',
    subscription_list_id int(11) NOT NULL,
    PRIMARY KEY  (contentobject_id,subscription_list_id)
)  ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS jaj_newsletter_delivery (
    id int(11) NOT NULL auto_increment,
    contentobject_id int(11) NOT NULL default '0',
    uuid CHAR(32) BINARY NOT NULL,
    email varchar(150) NOT NULL DEFAULT '',
    state varchar(12) NOT NULL DEFAULT '', 
    created int(11) NOT NULL default '0',
    sent int(11),
    opened int(11),
    viewed int(11),

    PRIMARY KEY  (id),
    UNIQUE (email, contentobject_id)
)  ENGINE=InnoDB;