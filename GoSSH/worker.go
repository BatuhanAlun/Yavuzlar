package main

import (
	"fmt"
	"sync"
)

func Worker(id int, creds <-chan Credentials, result chan<- Credentials, wg *sync.WaitGroup, host string, flag *bool, totaljob *int) {
	defer wg.Done()

	var succ bool
	for cred := range creds {
		*totaljob--
		fmt.Println(*totaljob)
		succ = ConnectSSH(cred.Username, cred.Password, host)
		if succ {
			fmt.Println("Successfully connected!")
			result <- cred
			*flag = true
		}
	}
}
