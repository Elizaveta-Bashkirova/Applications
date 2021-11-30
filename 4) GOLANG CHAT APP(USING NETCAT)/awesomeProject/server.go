
package main

import (
	"bufio"
	"fmt"
	"io"
	"log"
	"net"
	"os"
	"strings"
)

func main() {

	const maxUsers = 2

	users := make(map[net.Conn]string)
	newConnection := make(chan net.Conn)
	addedUser := make(chan net.Conn)
	deadUser := make(chan net.Conn)
	messages := make(chan string)      // channel that recieves messages from all users

	server, err := net.Listen("tcp", ":6001")
	if err != nil {
		fmt.Println(err)
		os.Exit(1)
	}

	go func() { //анонимная горутина
		for {
			conn, err := server.Accept()
			if err != nil {
				fmt.Println(err)
				os.Exit(1)
			}
			if len(users) < maxUsers {
				newConnection <- conn
			}else{
				io.WriteString(conn, "Server is full!")
			}
		}
	}()

	for {

		select {
		case conn := <-newConnection:

			go func(conn net.Conn) { //спрашиваем пользователя имя
				reader := bufio.NewReader(conn)
				io.WriteString(conn, "Enter name: ")
				userName, _ := reader.ReadString('\n')
				userName = strings.Trim(userName, "\r\n")
				log.Printf("Accepted new user : %s", userName)
				messages <- fmt.Sprintf("Accepted user : [%s]\n\n", userName)

				users[conn] = userName // добавляем соединение

				addedUser <- conn // добавляем этого пользователя в пул уже имеющих имя
			}(conn)

		case conn := <-addedUser: // пользователи, уже имеющие имя

			go func(conn net.Conn, userName string) {
				reader := bufio.NewReader(conn)
				for {
					newMessage, err := reader.ReadString('\n')
					newMessage = strings.Trim(newMessage, "\r\n")
					if err != nil {
						break
					}
					messages <- fmt.Sprintf(">%s: %s \a\n\n", userName, newMessage)
				}

				deadUser <- conn // если ошибка, то пользователя кикаем
				messages <- fmt.Sprintf(	"%s disconnected\n\n", userName)
			}(conn, users[conn])

		case message := <-messages: //

			for conn, _ := range users { // отправка всем пользотваелям
				go func(conn net.Conn, message string) { //
					_, err := io.WriteString(conn, message)
					if err != nil {
						deadUser <- conn
					}
				}(conn, message)
				log.Printf("New message: %s", message)
				log.Printf("Sent to %d users", len(users))
			}

		case conn := <-deadUser: // кик пользователей, которые ылетели
			log.Printf("Client disconnected")
			delete(users, conn)
		}
	}
}

