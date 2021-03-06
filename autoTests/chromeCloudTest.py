from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import json
import time

configFile = "config.json"
with open(configFile, "r") as f:
    config = json.load(f)

driver = webdriver.Chrome()
driver.get("http://73.229.199.171/")
assert "Pi In The Sky" in driver.title
elem = driver.find_element_by_name("username").send_keys(config["usernameNormal"])
elem = driver.find_element_by_name("password").send_keys(config["passwordNormal"])
elem = driver.find_element_by_name("login").click()
print("\nlogged in normal user")

elem = driver.find_element_by_link_text("Cloud Storage").click()
elem = driver.find_element_by_name("uploadFile").send_keys("/Users/mattbehrens/Documents/testWebsite/index.html")
elem = driver.find_element_by_name("privacy").click()
elem = driver.find_element_by_name("storage-submit").click()
print("\nsuccessfully uploaded a file to the cloud storage")

time.sleep(10)
elem = driver.find_element_by_link_text("Logout").click()
print("\nlogged user out")
driver.close()