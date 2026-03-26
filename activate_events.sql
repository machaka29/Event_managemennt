-- Update Event 1: School meeting to today
UPDATE events SET 
    date = '2026-03-25', 
    reg_start_date = '2026-03-01', 
    reg_end_date = '2026-03-31',
    status = 'approved'
WHERE id = 1;

-- Update Event 2: Companny to tomorrow
UPDATE events SET 
    date = '2026-03-26', 
    reg_start_date = '2026-03-01', 
    reg_end_date = '2026-03-31',
    status = 'approved'
WHERE id = 2;

-- Update registration for Juma Masoud to be recent (2 minutes ago)
UPDATE registrations SET 
    created_at = DATE_SUB(NOW(), INTERVAL 2 MINUTE),
    updated_at = NOW()
WHERE id = 5;
