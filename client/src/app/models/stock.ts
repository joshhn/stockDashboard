export interface Stock {
  ticker: string;
  name: string;
  address?: {
    address1?: string;
    city?: string;
    postal_code?: string;
    state?: string;
  };
  currency_name?: string;
  description?: string;
  homepage_url?: string;
  list_date?: string;
  locale?: string;
  market?: string;
  market_cap?: number;
  phone_number?: string;
  total_employees?: number;
}
