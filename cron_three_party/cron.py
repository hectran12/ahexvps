import requests, time, threading, colorama

BASE_URL = '<CRON_URL>' # URL CRON
KEY = '<YOUR_PASSWORD_CRON>' # PASSWORD CRON

count_request = 0
def action_cron (name_cron, path, time_period):
    global count_request
    while True:
        try:
            count_request += 1
            rq = requests.get(f'{BASE_URL}/{path}?key={KEY}', timeout=12000)
            if rq.status_code == 200:
                current_time = time.strftime('%Y-%m-%d %H:%M:%S', time.localtime())
                str_log = colorama.Fore.GREEN + f'[' + colorama.Fore.YELLOW + f'{current_time}' + colorama.Fore.GREEN + f'] ' + colorama.Fore.CYAN + f'{name_cron} ' + colorama.Fore.GREEN + f'is running... ' + colorama.Fore.RED + f'{count_request} requests'
                print(str_log)
            time.sleep(time_period)
        except Exception as e:
            print(e)
            time.sleep(5)
            continue


def open_cron (name_cron, path, time_period):
    threading.Thread(target=action_cron, args=(name_cron, path, time_period)).start()


# cron token agency
open_cron('TOKEN AGENCY', 'cron_three_party/cron_token.php', 1000) 

# cron product
open_cron('PRODUCT', 'cron_three_party/cron_product.php', 5)

# cron status vps
open_cron('STATUS VPS', 'cron_three_party/cron_status_vps.php', 5)

# cron xu ly order vps viet nam
open_cron('ORDER VPS VIET NAM', 'cron_three_party/xuly_order_vps_vietnam.php', 5)    

# cron bank
open_cron('BANK', 'cron_three_party/bank.php', 5)


# cron task
open_cron('TASK', 'cron_three_party/xuly_task_vps_vietnam.php', 1)

# cron gia hạn vps
open_cron('RENEW VPS', 'cron_three_party/cron_all_renew_vps_vietnam.php', 1200)
