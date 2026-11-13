<?php
declare(strict_types=1);
session_start();

define('DATA_DIR', __DIR__ . '/data');
define('USERS_FILE', DATA_DIR . '/users.json');
define('PORTAL_FILE', DATA_DIR . '/portal.json');

function load_json(string $file, array $fallback = []): array {
    if (!is_file($file)) return $fallback;
    $raw = file_get_contents($file);
    $decoded = json_decode($raw ?: '', true);
    return is_array($decoded) ? $decoded : $fallback;
}
function save_json(string $file, array $data): bool {
    if (!is_dir(DATA_DIR)) mkdir(DATA_DIR, 0750, true);
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return $json !== false && file_put_contents($file, $json, LOCK_EX) !== false;
}
function seed_data(): void {
    if (!is_file(USERS_FILE)) {
        $users = [
          ['id'=>1,'name'=>'Dushyant Singh','email'=>'student@campusone.demo','role'=>'student','password'=>password_hash('Student@123', PASSWORD_DEFAULT),'enrollment'=>'25CS003593','department'=>'CSE (Cybersecurity)','semester'=>'3rd'],
          ['id'=>2,'name'=>'Dr. Meera Joshi','email'=>'faculty@campusone.demo','role'=>'faculty','password'=>password_hash('Faculty@123', PASSWORD_DEFAULT),'department'=>'Computer Science','employee_id'=>'FAC102'],
          ['id'=>3,'name'=>'Campus Administrator','email'=>'admin@campusone.demo','role'=>'admin','password'=>password_hash('Admin@123', PASSWORD_DEFAULT),'department'=>'Administration','employee_id'=>'ADM001']
        ];
        save_json(USERS_FILE, $users);
    }
    if (!is_file(PORTAL_FILE)) {
        save_json(PORTAL_FILE, [
          'announcements'=>[
            ['id'=>1,'title'=>'Mid-semester examination schedule','message'=>'The examination timetable has been published. Please review the academic portal.','date'=>'2026-11-03','by'=>'Academic Office'],
            ['id'=>2,'title'=>'Fee payment reminder','message'=>'Semester fee balance is due by November 15, 2026.','date'=>'2026-11-02','by'=>'Accounts Department'],
            ['id'=>3,'title'=>'TechFest registrations open','message'=>'Register for workshops, coding competitions, and project showcases.','date'=>'2026-10-30','by'=>'Student Council']
          ],
          'attendance'=>[
            ['student'=>'Dushyant Singh','enrollment'=>'25CS003593','subject'=>'Operating Systems','attended'=>21,'total'=>24],
            ['student'=>'Dushyant Singh','enrollment'=>'25CS003593','subject'=>'Database Systems','attended'=>19,'total'=>22],
            ['student'=>'Dushyant Singh','enrollment'=>'25CS003593','subject'=>'Computer Networks','attended'=>18,'total'=>22],
            ['student'=>'Dushyant Singh','enrollment'=>'25CS003593','subject'=>'Data Structures','attended'=>23,'total'=>25],
            ['student'=>'Dushyant Singh','enrollment'=>'25CS003593','subject'=>'Discrete Mathematics','attended'=>17,'total'=>21],
            ['student'=>'Dushyant Singh','enrollment'=>'25CS003593','subject'=>'Web Development','attended'=>20,'total'=>23]
          ],
          'courses'=>[
            ['code'=>'CSE2301','name'=>'Operating Systems','faculty'=>'Dr. Meera Joshi','credits'=>4,'room'=>'A-103'],
            ['code'=>'CSE2302','name'=>'Database Systems','faculty'=>'Prof. R. Sharma','credits'=>4,'room'=>'B-204'],
            ['code'=>'CSE2303','name'=>'Computer Networks','faculty'=>'Prof. A. Khan','credits'=>3,'room'=>'C-12'],
            ['code'=>'CSE2304','name'=>'Data Structures','faculty'=>'Dr. N. Patel','credits'=>3,'room'=>'A-205'],
            ['code'=>'MAT2301','name'=>'Discrete Mathematics','faculty'=>'Dr. S. Verma','credits'=>2,'room'=>'B-101'],
            ['code'=>'CSE2305','name'=>'Web Development','faculty'=>'Prof. P. Gupta','credits'=>2,'room'=>'Lab W-3']
          ],
          'fees'=>['total'=>48500,'paid'=>36000,'balance'=>12500,'due'=>'2026-11-15'],
          'timetable'=>[
            ['day'=>'Monday','time'=>'09:00 - 10:00','subject'=>'Database Systems','room'=>'B-204'],
            ['day'=>'Monday','time'=>'10:30 - 11:30','subject'=>'Operating Systems','room'=>'A-103'],
            ['day'=>'Tuesday','time'=>'10:30 - 11:30','subject'=>'Database Systems','room'=>'B-204'],
            ['day'=>'Tuesday','time'=>'12:00 - 01:00','subject'=>'Computer Networks','room'=>'C-12'],
            ['day'=>'Wednesday','time'=>'09:00 - 10:00','subject'=>'Data Structures','room'=>'A-205'],
            ['day'=>'Thursday','time'=>'12:00 - 01:00','subject'=>'Web Development','room'=>'Lab W-3'],
            ['day'=>'Friday','time'=>'02:00 - 03:00','subject'=>'Discrete Mathematics','room'=>'B-101']
          ]
        ]);
    }
}
seed_data();

function current_user(): ?array { return $_SESSION['user'] ?? null; }
function require_login(): void {
    if (!current_user()) { header('Location: index.php'); exit; }
}
function require_role(array $roles): void {
    require_login();
    if (!in_array(current_user()['role'], $roles, true)) { http_response_code(403); exit('Access denied.'); }
}
function csrf_token(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verify_csrf(): void {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('Session expired. Refresh and try again.');
    }
}
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
function redirect_dashboard(): never {
    $role = current_user()['role'] ?? '';
    header('Location: dashboard.php'); exit;
}
