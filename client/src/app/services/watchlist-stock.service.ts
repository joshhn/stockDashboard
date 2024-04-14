import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { StorageService } from './storage.service';
import { Stock } from '../models/stock';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class WatchlistStockService {
  token: string | undefined;
  headerOptions: {};

  constructor(private http: HttpClient, private storageService: StorageService) {
    this.token = this.storageService.getUser()?.token;
    this.headerOptions = { headers: {Authorization: `Bearer ${this.token}`}};
  }

  getStocksByWatchlists(id: number): Observable<Stock[]> {
    return this.http.get<Stock[]>(`${environment.apiUrl}/watchlists/${id}/stocks`, this.headerOptions);
  }

  addStockToWatchlist(id: number, ticker: string): Observable<any> {
    return this.http.post(`${environment.apiUrl}/watchlists/${id}/stocks`, {ticker}, this.headerOptions);
  }

  removeStockFromWatchlist(id: number, ticker: string): Observable<any> {
    return this.http.delete(`${environment.apiUrl}/watchlists/${id}/stocks/${ticker}`, this.headerOptions);
  }
}