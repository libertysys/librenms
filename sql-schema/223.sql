CREATE TABLE device_relationships
(
    parent_device_id int(11) unsigned NOT NULL DEFAULT 0,
    child_device_id int(11) unsigned NOT NULL,
    CONSTRAINT device_children_device_id_child_device_id_pk PRIMARY KEY (parent_device_id, child_device_id),
    CONSTRAINT device_relationship_parent_device_id_fk FOREIGN KEY (parent_device_id) REFERENCES devices (device_id) ON DELETE CASCADE,
    CONSTRAINT device_relationship_child_device_id_fk FOREIGN KEY (child_device_id) REFERENCES devices (device_id) ON DELETE CASCADE
)ENGINE=InnoDB;
