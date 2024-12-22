package main

import (
	"bufio"
	"fmt"
	"os"
)

type Node struct {
	pass []string
	usrn []string
	host string
}

func ParseFlag(flag1, flag2, flag3, f1Val, f2Val, f3Val string) Node {
	username := []string{}
	password := []string{}
	var hostname string
	var credentials Node
	if flag1 == "-p" {
		password = append(password, f1Val)
	} else if flag1 == "-P" {
		f, err := os.Open(f1Val)
		if err != nil {
			panic(err)
		}
		r := bufio.NewReader(f)
		for {
			line, err := r.ReadString('\n')
			if err != nil {
				if err.Error() == "EOF" {
					if len(line) > 0 {
						password = append(password, line)
					}
				}
				break
			}
			password = append(password, line)
		}
		defer f.Close()
	} else if flag1 == "-u" {
		username = append(username, f1Val)
	} else if flag1 == "-U" {
		f, err := os.Open(f1Val)
		if err != nil {
			panic(err)
		}
		r := bufio.NewReader(f)
		for {
			line, err := r.ReadString('\n')
			if err != nil {
				if err.Error() == "EOF" {
					if len(line) > 0 {
						username = append(username, line)
					}
				}
				break
			}
			username = append(username, line)
		}
		defer f.Close()
	} else if flag1 == "-h" {
		hostname = f1Val
	} else {
		fmt.Println("Wrong Flag Usage!!")
		os.Exit(0)
	}

	//--------

	if flag2 == "-p" {
		password = append(password, f2Val)
	} else if flag2 == "-P" {
		f, err := os.Open(f2Val)
		if err != nil {
			panic(err)
		}
		r := bufio.NewReader(f)
		for {
			line, err := r.ReadString('\n')
			if err != nil {
				if err.Error() == "EOF" {
					if len(line) > 0 {
						password = append(password, line)
					}
				}
				break
			}
			password = append(password, line)
		}
		defer f.Close()
	} else if flag2 == "-u" {
		username = append(username, f2Val)
	} else if flag2 == "-U" {
		f, err := os.Open(f2Val)
		if err != nil {
			panic(err)
		}
		r := bufio.NewReader(f)
		for {
			line, err := r.ReadString('\n')
			if err != nil {
				if err.Error() == "EOF" {
					if len(line) > 0 {
						username = append(username, line)
					}
				}
				break
			}
			username = append(username, line)
		}
		defer f.Close()
	} else if flag2 == "-h" {
		hostname = f2Val
	} else {
		fmt.Println("Wrong Flag Usage!!")
		os.Exit(0)
	}

	//--------

	if flag3 == "-p" {
		password = append(password, f3Val)
	} else if flag3 == "-P" {
		f, err := os.Open(f3Val)
		if err != nil {
			panic(err)
		}
		r := bufio.NewReader(f)
		for {
			line, err := r.ReadString('\n')
			if err != nil {
				if err.Error() == "EOF" {
					if len(line) > 0 {
						password = append(password, line)
					}
				}
				break
			}
			password = append(password, line)
		}
		defer f.Close()
	} else if flag3 == "-u" {
		username = append(username, f3Val)
	} else if flag3 == "-U" {
		f, err := os.Open(f3Val)
		if err != nil {
			panic(err)
		}
		r := bufio.NewReader(f)
		for {
			line, err := r.ReadString('\n')
			if err != nil {
				if err.Error() == "EOF" {
					if len(line) > 0 {
						username = append(username, line)
					}
				}
				break
			}
			username = append(username, line)
		}
		defer f.Close()
	} else if flag3 == "-h" {
		hostname = f3Val
	} else {
		fmt.Println("Wrong Flag Usage!!")
		os.Exit(0)
	}

	credentials.pass = make([]string, len(password))
	credentials.usrn = make([]string, len(username))
	credentials.host = hostname
	copy(credentials.pass, password)
	copy(credentials.usrn, username)
	return credentials
}
