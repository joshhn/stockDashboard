export interface News {
  id: string;
  publisher: {
    name: string;
    homepage_url: string;
    logo_url: string;
    favicon_url?: string;
  };
  title: string;
  author: string;
  published_utc: string;
  article_url: string;
  tickers: string[];
  image_url?: string;
  description?: string;
  keywords?: string[];
}
