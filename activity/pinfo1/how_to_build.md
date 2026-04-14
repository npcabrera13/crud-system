# GUIDE: BUILDING THE RESEARCH APPROVAL SYSTEM
---

This guide provides step-by-step instructions on how to recreate the Research Approval Workflow from scratch.

---

## 🏗️ PHASE 1: DATABASE SETUP
First, you need a "Staging Area" in your database where pending records live.

1. **Create the Table**: Run this SQL in your phpMyAdmin. It creates a copy of your main table structure.
```sql
CREATE TABLE temp_research LIKE researches;
```

---

## 🛠️ PHASE 2: REDIRECTING SUBMISSIONS
Next, we change the "Add Research" form so it doesn't immediately go to the public list.

1. **File**: `Research/config/Research.php`
2. **Location**: **Around Line 52** (inside the `Add()` function).
3. **Action**: Change the target table in the SQL query.

**The Code**:
```php
// Change 'researches' to 'temp_research'
$stmt = $this->con->prepare("INSERT INTO temp_research (...) VALUES (...)");
```

---

## 🧠 PHASE 3: THE APPROVAL ENGINE
Now, we add the "intelligence" to move data when you click Accept.

1. **File**: `Research/config/Research.php`
2. **Location**: **Starting at Line 137**.
3. **Action**: Add the methods for handling and processing actions.

**Key Logic**:
- **Line 137**: `handleApprovals()` - Listens for button clicks.
- **Line 153**: `accept($id)` - Copies data and moves it to the main table.
- **Line 173**: `decline($id)` - Deletes data from the temp table.

---

## 🖥️ PHASE 4: THE PENDING TABLE COMPONENT
We create a separate file to hold the HTML for the Pending table.

1. **File**: `tempresearch.php` (in your project root)
2. **Action**: Paste the HTML table code here.
3. **Important**: Ensure the buttons are wrapped in a `<form method="POST">` so they can trigger the logic.

---

## 🔗 PHASE 5: FINAL INTEGRATION
Finally, we "glue" everything together on the main dashboard page.

1. **File**: `Research/index.php`
2. **Action**: 
   - **Line 3**: Add `$research->handleApprovals();` (Must be at the very top before any HTML!).
   - **Page Footer**: Add `include "../tempresearch.php";` where you want the table to appear.

---

### 💡 SUMMARY OF THE "SECRET SAUCE"
If you want to do this on your own, remember the **Logic Flow**:
1. User Submits $\rightarrow$ Save to **Temp**.
2. Admin looks at **Temp**.
3. Admin clicks **Accept** $\rightarrow$ Code copies from **Temp** to **Main** then deletes **Temp**.

> [!IMPORTANT]
> Always put the `handleApprovals()` logic at the very top of the page (before any HTML) to avoid the "Headers already sent" error!
