package main

import (
	"fmt"
	"os"
	"time"
)

// slice of users
var users = []Users{
	{Username: "admin", Password: "admin"},
	{Username: "user", Password: "user"},
}

type Users struct {
	Username string
	Password string
}

var fileName string = "log.txt"

// Username check function
func isExist(uname string) int {

	for i := 0; i < len(users); i++ {
		if uname == users[i].Username {
			return i
		}
	}
	return 0
}

func isExistPanel(uname string) int {

	for i := 0; i < len(users); i++ {
		if uname == users[i].Username {
			return 1
		}
	}
	return 0
}

func listUsernames() int {
	for i := 0; i < len(users); i++ {
		fmt.Println(i, "-", users[i].Username)

	}
	return 1
}

func login(index int, passwd string) int {
	if index == 0 && passwd == "admin" {
		fmt.Println("Welcome Back Admin!")
		return 1
	}
	uname := users[index]
	if uname.Password == passwd {
		fmt.Println("Welcome,", uname.Username)
		return 1

	}
	return 0
}

func addUser() int {
	var uname string
	var passwd string
	var repasswd string

	for {
		fmt.Println("Please Enter New User's Username")
		fmt.Scanln(&uname)
		exist := isExistPanel(uname)
		if exist == 0 {
			fmt.Println("Please Enter New User's Password")
			fmt.Scanln(&passwd)
			fmt.Println("Please Re-Enter New User's Password")
			fmt.Scanln(&repasswd)
			users = append(users, Users{Username: uname, Password: passwd})
			return 1
		} else {
			fmt.Println("Username Already Exist!")
		}
	}
}

func delUser(index int) int {
	if index < 0 || index >= len(users) {
		fmt.Println("Invalid index")
		return 0
	} else {
		users = append(users[:index], users[index+1:]...)
		return 1
	}

}

func viewProfile(index int) {

	fmt.Println("-------------------------------------")
	fmt.Println("|Your Username:", users[index].Username)
	fmt.Println("|Your Password:", users[index].Password)
	fmt.Println("-------------------------------------")

}

func changePasswd(index int) {

	var pass, pass1 string
	fmt.Println("Please Enter Your New Password")
	fmt.Scanln(&pass)
	fmt.Println("Please Re-Enter Your New Password")
	fmt.Scanln(&pass1)
	users[index].Password = pass

}

func writeFile(content string) {

	file, err := os.OpenFile(fileName, os.O_APPEND|os.O_CREATE|os.O_WRONLY, 0644)
	if err != nil {
		fmt.Println("Error opening or creating file:", err)
		return
	}
	defer file.Close()

	_, err = file.WriteString(content)
	if err != nil {
		fmt.Println("Error writing to file:", err)
		return
	}
}

func readLogs() {

	content, err := os.ReadFile(fileName)
	if err != nil {
		fmt.Println("Error reading file:", err)
		return
	}

	fmt.Println(string(content))
}

func userLoop(index int) {
	for {
		var selection int
		fmt.Println("What do you want to do User ?")
		fmt.Println("View Profile --> 0")
		fmt.Println("Change Password --> 1")
		fmt.Println("Exit --> 2")

		fmt.Scanln(&selection)
		switch selection {
		case 0:
			viewProfile(index)
		case 1:
			changePasswd(index)
		case 2:
			return
		default:
			fmt.Println("Wrong Selection!!")
		}
	}

}

func adminLoop() {
	var selection int
	var success int
	for {
		fmt.Println("What do you want to do Admin ?")
		fmt.Println("Add User --> 0")
		fmt.Println("Delete User --> 1")
		fmt.Println("View Logs --> 2")
		fmt.Println("Exit --> 3")
		fmt.Scanln(&selection)

		switch selection {
		case 0:
			success = addUser()
			if success == 1 {
				fmt.Println("User Successfully Added!")
			} else {
				fmt.Println("Something Went Wrong(alx0)")
			}
		case 1:
			var delIndex int
			listUsernames()
			fmt.Println("Please Select The Index of User to Delete")
			fmt.Scanln(&delIndex)
			success = delUser(delIndex)
			if success == 1 {
				fmt.Println("User Sucessfully Deleted!")
			}

		case 2:
			readLogs()

		case 3:
			return
		default:
			fmt.Println("Wrong Input")
		}
	}
}

func main() {
	var i int
	var uname string
	var passwd string
	var success int
	var loginSuccess int
	var logEntry string
	cTime := time.Now()

	file, err := os.OpenFile(fileName, os.O_RDWR|os.O_CREATE, 0644)
	if err != nil {
		fmt.Println("Error opening file:", err)
		return
	}
	defer file.Close()

	_, err = file.WriteString("Logs:\n")
	if err != nil {
		fmt.Println("Error on file:", err)
	}
	for {
		fmt.Println("Welcome To Login System:")
		fmt.Println("Enter 3 For Exit!")
		fmt.Println("System Clock:", cTime.Format(time.RFC3339))
		fmt.Scanln(&i)

		if i == 0 {
			fmt.Println("Welcome Admin!")
			fmt.Println("Please Enter Your Username")
			fmt.Scanln(&uname)
			fmt.Println("Please Enter Your Password")
			fmt.Scanln(&passwd)
			success = isExist(uname)
			if uname != "admin" {
				success = 1
			}
			if success == 0 {
				loginSuccess = login(success, passwd)
				if loginSuccess != 1 {
					for j := 0; j < 2; j++ {
						cTime = time.Now()
						logEntry = cTime.Format(time.RFC3339) + " Wrong Password Entry by Admin" + "\n"
						writeFile(logEntry)
						fmt.Println("Wrong, password!")
						fmt.Println("You left", 3-(j+1), "tries")
						fmt.Println("Please Re-Enter Your Password")
						fmt.Scanln(&passwd)
						loginSuccess = login(success, passwd)
						if loginSuccess == 1 {
							//log entry
							cTime = time.Now()
							logEntry = cTime.Format(time.RFC3339) + " Successfull Entry by Admin" + "\n"
							writeFile(logEntry)
							adminLoop()
							j = 10

						} else if j == 1 {
							//log entry
							cTime = time.Now()
							logEntry = cTime.Format(time.RFC3339) + " Too Mant Incorrect Tries" + "\n"
							writeFile(logEntry)

							fmt.Println("Too many Incorrect Tries")
							fmt.Print("Exiting...")
							os.Exit(0)

						}
					}

				} else {
					cTime = time.Now()
					logEntry = cTime.Format(time.RFC3339) + " Successfull Entry By Admin" + "\n"
					writeFile(logEntry)
					//log entry
					adminLoop()
				}
			} else {
				cTime = time.Now()
				logEntry = cTime.Format(time.RFC3339) + " Wrong Username" + "\n"
				writeFile(logEntry)
				//log entry
				fmt.Println("Username Does Not Exist")
				fmt.Println("Exiting...")
			}

		} else if i == 1 {
			fmt.Println("Welcome User!")
			fmt.Println("Please Enter Your Username")
			fmt.Scanln(&uname)
			fmt.Println("Please Enter Your Password")
			fmt.Scanln(&passwd)
			success = isExist(uname)
			if success > 0 {
				loginSuccess = login(success, passwd)
				if loginSuccess != 1 {
					for j := 0; j < 2; j++ {
						cTime = time.Now()
						logEntry = cTime.Format(time.RFC3339) + " Wrong Password Entry by" + " " + users[success].Username + "\n"
						writeFile(logEntry)
						//log entry
						fmt.Println("Wrong, password!")
						fmt.Println("You left", 3-(j+1), "tries")
						fmt.Println("Please Re-Enter Your Password")
						fmt.Scanln(&passwd)
						loginSuccess = login(success, passwd)
						if loginSuccess == 1 {
							cTime = time.Now()
							logEntry = cTime.Format(time.RFC3339) + " Successfull Entry by" + " " + users[success].Username + "\n"
							writeFile(logEntry)
							//log entry
							userLoop(success)
							j = 10
						} else if j == 1 {
							cTime = time.Now()
							logEntry = cTime.Format(time.RFC3339) + " Too Many incorrect tries by" + " " + users[success].Username + "\n"
							writeFile(logEntry)
							//log entry
							fmt.Println("Too many Incorrect Tries")
							fmt.Print("Exiting...")
							os.Exit(0)
						}
					}

				} else {
					cTime = time.Now()
					logEntry = cTime.Format(time.RFC3339) + " Successfull Entry by" + " " + users[success].Username + "\n"
					writeFile(logEntry)
					//log enrty
					userLoop(success)
				}
			} else {

				cTime = time.Now()
				logEntry = cTime.Format(time.RFC3339) + " Username Does Not exist" + "\n"
				writeFile(logEntry)
				//log entry

				fmt.Println("Username Does Not Exist")
				fmt.Println("Exiting...")
			}
		} else {
			fmt.Println("Exiting...")
			os.Exit(0)
		}

	}
}
