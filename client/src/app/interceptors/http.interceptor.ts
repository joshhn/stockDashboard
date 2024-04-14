import { HttpInterceptorFn } from '@angular/common/http';

export const httpInterceptor: HttpInterceptorFn = (req, next) => {
  req = req.clone({
    headers: req.headers.set('Content-Type', 'application/json'),
    withCredentials: true
  });
  return next(req);
};
