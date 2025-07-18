<?php
declare(strict_types=1);

/*
  RSS Feed Generator for PHP 4+ 
  Version 1.0.3
  Classes in package:
    rssGenerator_rss, rssGenerator_channel,
    rssGenerator_image, rssGenerator_textInput,
    rssGenerator_item
*/

class rssGenerator_rss
{
    public string $rss_version = '2.0';
    public string $encoding    = '';
    public string $stylesheet   = '';

    public function cData(string $str): string
    {
        return '<![CDATA[' . $str . ']]>';
    }

    public function createFeed(rssGenerator_channel $channel): string
    {
        $xml  = '<?xml version="1.0"';
        if ($this->encoding) {
            $xml .= ' encoding="' . $this->encoding . '"';
        }
        $xml .= '?>' . "\n";

        if ($this->stylesheet) {
            $xml .= '<?xml-stylesheet href="' . $this->stylesheet . '"?>' . "\n";
        }

        $xml .= "<rss version=\"{$this->rss_version}\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
        $xml .= "  <channel>\n"
              . "    <title>"   . $this->cData($channel->title) . "</title>\n"
              . "    <link>{$channel->link}</link>\n"
              . "    <description>" . $this->cData($channel->description) . "</description>\n";

        // … بقیه‌ی عناصر اختیاری مثل language, pubDate, image, textInput و items

        foreach ($channel->items as $itm) {
            $xml .= "    <item>\n"
                  . "      <title>" . $this->cData($itm->title) . "</title>\n"
                  . "      <link>{$itm->link}</link>\n"
                  . "      <description>" . $this->cData($itm->description) . "</description>\n";
            // … بقیه‌ی فیلدهای item
            $xml .= "    </item>\n";
        }

        $xml .= "  </channel>\n</rss>";
        return $xml;
    }
}

class rssGenerator_channel { /* … تعریف propertyها و آرایه items */ }
class rssGenerator_image   { /* … */ }
class rssGenerator_textInput { /* … */ }
class rssGenerator_item    { /* … */ }