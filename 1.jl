1. users

id (PK)
merchant_id (FK to merchants)
name
email
password
role (admin, sub-account, staff)
status (active, suspended)
created_at

2. merchants

id (PK)
company_name
email
phone
address
logo
industry_type
created_at

3. departments

id (PK)
merchant_id
department_name
head_user_id (FK to users)
status (active/inactive)
created_at

4. item_categories

id (PK)
merchant_id
name
description
status
created_at

5. inventory_items

id (PK)
merchant_id
item_name
item_code (unique per merchant)
category_id (FK to item_categories)
quantity_available
quantity_total
unit_type (kg, pcs, liters, etc.)
condition (new, used, damaged)
location
status (available, allocated, used)
created_at

6. item_transactions

id (PK)
merchant_id
item_id
transaction_type (restock, replenish, allocate, return, use)
quantity
performed_by (FK to users)
remarks
created_at
7. item_allocations
sql
Copy
Edit
id (PK)
merchant_id
item_id
staff_user_id
quantity
allocated_date
return_date (nullable)
status (active, returned)

8. sub_accounts

id (PK)
merchant_id
user_id (FK to users)
can_manage_inventory (bool)
can_manage_staff (bool)
can_view_reports (bool)
created_at

9. audit_logs

id (PK)
merchant_id
user_id
action_type
description
action_time
ip_address