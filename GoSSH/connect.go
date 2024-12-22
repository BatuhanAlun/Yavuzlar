package main

import (
	"log"

	"golang.org/x/crypto/ssh"
)

func ConnectSSH(username, password, host string) bool {

	config := &ssh.ClientConfig{
		User: username, //server username
		Auth: []ssh.AuthMethod{
			ssh.Password(password), //password
		},
		HostKeyCallback: ssh.InsecureIgnoreHostKey(),
	}

	_, err := ssh.Dial("tcp", host+":22", config) //ip and config
	if err != nil {
		return false
	} else {
		log.Println("Succesfully Connected!!")
		return true
	}

}
