CREATE OR REPLACE TABLE selection (
    PRIMARY KEY (material_id),
    material_id             INT             AUTO_INCREMENT,
    material_title          VARCHAR(256)    NOT NULL,

    material_date_received  DATE            NOT NULL,
    material_date_created   DATE            NOT NULL,
        CHECK (material_date_created <= material_date_received), -- dates must be sensible
    material_is_pending     BOOLEAN         NOT NULL DEFAULT TRUE,
    material_price          DECIMAL(10, 2)  NOT NULL,
        CHECK (material_price > 0), -- no negative prices on books,
    material_is_active      BOOLEAN         NOT NULL DEFAULT TRUE -- for DENY deletion rule
);
