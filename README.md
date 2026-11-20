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

## Git 工作方式

老師會看每個人的 commit 紀錄，所以請各自用自己的帳號 commit。

1. 每個功能開一個分支，例如 `feature/spaces-search`、`feature/reservation-form`
2. 小步 commit，訊息寫清楚做了什麼，例如「預約表單：加入物品多選」
3. 推上 GitHub 後開 Pull Request，請另一位組員看過再合併到 `main`
4. 開始工作前先 `git pull` 拿最新的 `main`

## 完整款整合（最後一週）

- 空間查詢 ↔ 借用：教室詳細頁加上「預約這間教室」，週借用表也顯示該教室資訊
- 排課 ↔ 借用：預約時檢查是否和已排的課程衝突，週借用表同時顯示課程
