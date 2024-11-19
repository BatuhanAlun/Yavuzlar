package main

import (
	"encoding/csv"
	"fmt"
	"log"
	"os"

	"github.com/gocolly/colly"
)

type Data struct {
	title, bodytext, date string
}

func trimLeftChar(s string) string {
	for i := range s {
		if i > 0 {
			return s[i:]
		}
	}
	return s[:0]
}

func main() {

	var menu int
	var webdata []Data

	fmt.Println("Welcome To Scraper")
	fmt.Printf("What do you wanna do?\nScrape 'thehackernews'(-1)\nScraping Course(-2)\nYavuzlar(-3)\nExit(-4)")
	fmt.Scanln(&menu)

	switch menu {
	case -1:
		fmt.Println("Scraping HackerNews...")
		c := colly.NewCollector()

		c.OnHTML(".clear.home-right", func(e *colly.HTMLElement) {

			data := Data{}
			data.title = "Title:" + e.ChildText((".home-title"))
			data.bodytext = e.ChildText((".home-desc"))
			data.date = e.ChildText((".h-datetime"))
			webdata = append(webdata, data)
		})

		c.OnScraped(func(r *colly.Response) {

			file, err := os.Create("hackernews.csv")
			if err != nil {
				log.Fatalln("Failed to create output CSV file", err)
			}
			defer file.Close()
			writer := csv.NewWriter(file)

			headers := []string{
				"Title",
				"Description",
				"Date",
			}
			writer.Write(headers)

			for _, data := range webdata {

				record := []string{
					data.title,
					data.bodytext,
					trimLeftChar(data.date),
				}
				writer.Write(record)
			}
			defer writer.Flush()
		})

		err := c.Visit("https://thehackernews.com/")
		if err != nil {
			fmt.Println("Visit error:", err)
		}

	case -2:
		fmt.Println("Scraping HackerNews...")
		c := colly.NewCollector()

		c.OnHTML(".clear.home-right", func(e *colly.HTMLElement) {

			data := Data{}
			data.title = "Title:" + e.ChildText((".home-title"))
			data.bodytext = e.ChildText((".home-desc"))
			data.date = e.ChildText((".h-datetime"))
			webdata = append(webdata, data)
		})

		c.OnScraped(func(r *colly.Response) {

			file, err := os.Create("hackernews.csv")
			if err != nil {
				log.Fatalln("Failed to create output CSV file", err)
			}
			defer file.Close()
			writer := csv.NewWriter(file)

			headers := []string{
				"Title",
				"Description",
				"Date",
			}
			writer.Write(headers)

			for _, data := range webdata {

				record := []string{
					data.title,
					data.bodytext,
					trimLeftChar(data.date),
				}
				writer.Write(record)
			}
			defer writer.Flush()
		})

		err := c.Visit("https://thehackernews.com/")
		if err != nil {
			fmt.Println("Visit error:", err)
		}

	case -3:

	case -4:
		fmt.Println("Exiting...")
		os.Exit(0)
	}

}
