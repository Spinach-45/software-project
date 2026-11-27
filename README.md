# 管院空間與排課系統

軟體工程學期專案。三個模組共用同一套帳號與同一個 PostgreSQL 資料庫。

- 技術：Laravel 13（PHP 8.3）+ PostgreSQL
- 頁面：Blade 樣板 + 純 CSS（`public/css/app.css`），不需要 Node.js 或打包工具

## 本機安裝

需要先安裝 PHP 8.3 以上、Composer、PostgreSQL。

```bash
git clone https://github.com/Spinach-45/software-project.git
cd software-project
composer install
cp .env.example .env
php artisan key:generate
```

在 PostgreSQL 建立資料庫與帳號（和 `.env` 的設定一致，可自行修改）：

```sql
CREATE USER sp WITH PASSWORD 'sp' CREATEDB;
CREATE DATABASE software_project OWNER sp;
```

建立資料表與測試資料，然後啟動：

```bash
php artisan migrate:fresh --seed
php artisan serve
```

打開 http://localhost:8000

### 測試帳號（密碼都是 `password`）

| Email | 身分 |
|---|---|
| admin@example.com | 管理員 |
| teacher@example.com | 老師（王老師） |
| teacher2@example.com | 老師（李老師） |
| user@example.com | 一般使用者 |
| pending@example.com | 待審核，無法登入 |

### 執行測試

```bash
php artisan test
```

## 分工

| 模組 | 負責人 | 主要檔案 |
|---|---|---|
| 共用：帳號註冊、審核、登入登出 | （待填） | `app/Http/Controllers/Auth/`、`Admin/UserController.php`、`app/Http/Middleware/EnsureRole.php` |
| 模組一：管院空間查詢 | （待填） | `Spaces/SpaceController.php`、`Admin/RoomController.php`、`resources/views/spaces/` |
| 模組二：空間/物品預約借用 | （待填） | `Reservations/ReservationController.php`、`Admin/ReservationReviewController.php`、`resources/views/reservations/` |
| 模組三：志願排課 | （待填） | `Courses/CourseController.php`、`Admin/CourseAdminController.php`、`resources/views/courses/` |

每個 Controller 裡面都標了 `TODO(模組一)`、`TODO(模組二)`、`TODO(模組三)`，搜尋就能找到自己要做的地方。還沒做的頁面會顯示黃色的「這個頁面還沒做」提示。

## 已完成的部分

- 共用帳號：註冊（選一般使用者或老師）、新帳號預設待審核、管理員審核與調整角色、登入登出
- 權限：`auth` 需登入、`role:admin`、`role:teacher,admin`
- 資料表：`users`（含 role、status）、`rooms`、`items`、`reservations`、`item_reservation`、`courses`
- 所有模組的路由（`routes/web.php`）和列表頁
- 360 全景照片：教室詳細頁已接好 Pannellum，只要在 `rooms.panorama_path` 填入 `public/` 底下的圖片路徑
- 排課衝突查詢（同教室同時段）的 SQL 已寫好
- 測試資料與 11 個基本測試

## 資料表

| 資料表 | 用途 | 使用的模組 |
|---|---|---|
| users | 帳號，`role` = admin / teacher / user，`status` = pending / approved / rejected | 全部 |
| rooms | 教室：編號、名稱、樓層、類型、容納人數、設備、全景照片、平面圖座標 | 全部 |
| items | 可借用物品：鑰匙、投影筆、筆電… | 模組二 |
| reservations | 預約單：教室、日期、時段、狀態、審核意見、借出與歸還時間 | 模組二 |
| item_reservation | 預約單借了哪些物品、幾個 | 模組二 |
| courses | 課程：老師、希望教室、日期、時段 | 模組三 |

要改資料表時，請新增一個 migration（`php artisan make:migration ...`），不要直接改別人的 migration，以免組員的資料庫對不上。

## Git 分支與 PR 規則

老師會看每個人的 commit 紀錄，所以請各自用自己的帳號 commit。

### 分支

| 分支 | 用途 |
|---|---|
| `main` | 可以正常執行的整合版本，**不要直接 push** |
| `feature/module1-space` | 模組一：管院空間查詢 |
| `feature/module2-booking` | 模組二：空間/物品預約借用 |
| `feature/module3-course` | 模組三：志願排課 |

每個人在自己模組的分支上開發。如果想同時做好幾件事，也可以從自己的分支再開小分支，例如 `feature/module2-booking-form`。

### 第一次設定

```bash
git fetch origin
git switch feature/module1-space   # 換成自己的分支
```

### 日常流程

1. 開始工作前，先把最新的 `main` 拉進自己的分支：
   ```bash
   git switch main && git pull
   git switch feature/module1-space
   git merge main
   ```
2. 小步 commit，訊息寫清楚做了什麼，例如「預約表單：加入物品多選」。
3. `git push` 推到自己的分支。
4. 完成一段可以用的功能（例如一個頁面、一個表單）就開 Pull Request 合併到 `main`，不要等到最後才一次合併。
5. PR 至少要有**一位其他組員 review 並 approve** 才能合併。合併前確認 `php artisan test` 會過。
6. 合併後再做一次步驟 1，讓自己的分支跟上 `main`。

### 共用檔案

下面這些檔案大家都會用到，最容易衝突。**要改之前先在群組說一聲**，改完盡快開 PR 合併：

- `database/migrations/`：要改資料表就新增一個 migration，不要改已經存在的 migration
- `database/seeders/`
- `public/css/app.css`
- `resources/views/layouts/`（版面樣板）
- `routes/web.php`
- 共用帳號相關：`app/Http/Controllers/Auth/`、`app/Http/Middleware/`、`app/Models/User.php`

### 遇到衝突

`git merge main` 出現衝突時，打開有衝突的檔案，保留雙方需要的程式碼，刪掉 `<<<<<<<`、`=======`、`>>>>>>>` 標記，再 `git add` 和 `git commit`。不確定別人的程式碼要不要留，就先問寫那段的組員。

## 完整款整合（最後一週）

- 空間查詢 ↔ 借用：教室詳細頁加上「預約這間教室」，週借用表也顯示該教室資訊
- 排課 ↔ 借用：預約時檢查是否和已排的課程衝突，週借用表同時顯示課程
