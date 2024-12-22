package main

import (
	"fmt"
	"os"
	"sync"
)

type Credentials struct {
	Username string
	Password string
}

func main() {
	credentialsList := []Credentials{}
	var cred Node
	if len(os.Args) != 7 {
		fmt.Println("Wrong Argument Entry")
		fmt.Println("Usage : ./prog -flag1 flag1val -flag2 flag2val flag3 flag3val")
		os.Exit(0)
	}

	flag1 := os.Args[1]
	flag1Val := os.Args[2]
	flag2 := os.Args[3]
	flag2Val := os.Args[4]
	flag3 := os.Args[5]
	flag3Val := os.Args[6]

	if flag1 == flag2 || flag2 == flag3 || flag3 == flag1 {
		fmt.Println("You Cannot Use Same Flag Twice!!")
		os.Exit(0)
	}

	cred = ParseFlag(flag1, flag2, flag3, flag1Val, flag2Val, flag3Val)

	for _, pass := range cred.pass {
		for _, user := range cred.usrn {
			credentialsList = append(credentialsList, Credentials{
				Username: user,
				Password: pass,
			})
		}
	}
	var totaljob int = len(cred.pass) * len(cred.usrn)
	jobs := make(chan Credentials, 100)
	results := make(chan Credentials, 100)
	var wg sync.WaitGroup
	var hostn string = cred.host
	var flag bool

	for w := 1; w <= 3; w++ {
		wg.Add(1)
		go Worker(w, jobs, results, &wg, hostn, &flag, &totaljob)
	}

	for _, foo := range credentialsList {
		jobs <- foo
	}
	close(jobs)

	wg.Wait()
	close(results)

	for cred := range results {
		fmt.Println("Username : ", cred.Username)
		fmt.Println("Password : ", cred.Password)
	}
	if !flag {
		fmt.Println("All Attempts Failed!")
	}
}
