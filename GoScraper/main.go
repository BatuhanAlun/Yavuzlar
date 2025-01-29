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
type ScrapeCourse struct {
	Url, Pname, Price string
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
	var scrapeCourse []ScrapeCourse

	fmt.Println("Welcome To Scraper")
	fmt.Printf("What do you wanna do?\nScrape 'thehackernews'(-1)\nScraping Course(-2)\nPagination(-3)\nExit(-4)")
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
		fmt.Println("Scraping Scrape Course...")
		c := colly.NewCollector()

		c.OnHTML("li.product", func(e *colly.HTMLElement) {

			data := ScrapeCourse{}
			data.Url = e.ChildAttr("a", "href")
			data.Pname = e.ChildText(".product-name")
			data.Price = e.ChildText((".price"))
			scrapeCourse = append(scrapeCourse, data)
		})

		c.OnScraped(func(r *colly.Response) {

			file, err := os.Create("scrapecourse.csv")
			if err != nil {
				log.Fatalln("Failed to create output CSV file", err)
			}
			defer file.Close()
			writer := csv.NewWriter(file)

			headers := []string{
				"Url",
				"ProductName",
				"Price",
			}
			writer.Write(headers)

			for _, data := range scrapeCourse {

				record := []string{
					data.Url,
					data.Pname,
					data.Price,
				}
				writer.Write(record)
			}
			defer writer.Flush()
		})

		err := c.Visit("https://www.scrapingcourse.com/ecommerce/")
		if err != nil {
			fmt.Println("Visit error:", err)
		}

	case -3:

		fmt.Println("Scraping Scrape Course...")
		c := colly.NewCollector()

		c.OnHTML(".product-item", func(e *colly.HTMLElement) {

			data := ScrapeCourse{}
			data.Url = e.ChildAttr("a", "href")
			data.Pname = e.ChildText(".product-name")
			data.Price = e.ChildText((".product-price"))
			scrapeCourse = append(scrapeCourse, data)
		})

		c.OnHTML("a[rel='next']", func(e *colly.HTMLElement) {
			nextPage := e.Attr("href")
			fmt.Println("Navigating to:", nextPage)
			e.Request.Visit(nextPage)
		})

		c.OnScraped(func(r *colly.Response) {

			file, err := os.Create("ScrapePagination.csv")
			if err != nil {
				log.Fatalln("Failed to create output CSV file", err)
			}
			defer file.Close()
			writer := csv.NewWriter(file)

			headers := []string{
				"Url",
				"ProductName",
				"Price",
			}
			writer.Write(headers)

			for _, data := range scrapeCourse {

				record := []string{
					data.Url,
					data.Pname,
					data.Price,
				}
				writer.Write(record)
			}
			defer writer.Flush()
		})

		err := c.Visit("https://www.scrapingcourse.com/pagination/")
		if err != nil {
			fmt.Println("Visit error:", err)
		}

	case -4:
		fmt.Println("Exiting...")
		os.Exit(0)
	}

}
