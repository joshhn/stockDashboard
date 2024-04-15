import { Stock } from "./stock";

export interface Watchlist {
  id: number;
  name: string;
  stocks: Stock[];
}
