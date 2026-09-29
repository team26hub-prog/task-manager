CREATE TABLE IF NOT EXISTS employees (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NULL UNIQUE,
    department VARCHAR(120) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE tasks
    ADD COLUMN employee_id INT UNSIGNED NULL,
    ADD INDEX idx_tasks_employee_id (employee_id),
    ADD CONSTRAINT fk_tasks_employee
        FOREIGN KEY (employee_id) REFERENCES employees(id)
        ON DELETE SET NULL;
