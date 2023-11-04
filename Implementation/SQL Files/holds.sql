CREATE OR REPLACE holds (
    PRIMARY KEY (interaction_id),
    interaction_id          INT,
    hold_date_requested     DATE        NOT NULL,
    hold_is_active          BOOLEAN     NOT NULL DEFAULT TRUE
);