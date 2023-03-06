;; The first three lines of this file were inserted by DrRacket. They record metadata
;; about the language level of this file in a form that our tools can easily process.
#reader(lib "htdp-beginner-abbr-reader.ss" "lang")((modname tp1) (read-case-sensitive #t) (teachpacks ()) (htdp-settings #(#t write repeating-decimal #f #t none #f () #f)))
(define singleton
  (lambda (x)
    (if (null? (cdr x)) #t #f)
  ))

(define longueur
  (lambda (x)
    (if (null? x)
        0
        (+ 1 (longueur (cdr x))))
    ))

;(singleton '(a))
;(singleton '(a b c))

;(longueur '(a b c))
;(longueur '(c))
;(longueur '())

(define nieme
  (lambda (n l)
    (if (= n 1) (car l) (nieme (- n 1) (cdr l)))
    ))

; (nieme 3 '(a z e r t y)) ; -> e
; (nieme 1 '(a z e r t y)) ; -> a
; (nieme 6 '(a z e r t y)) ; -> y
; (nieme 1 '(a)) ; -> a


(define dernier
  (lambda (l)
    (if (null? (cdr l)) (car l) (dernier (cdr l)))
    ))

; (dernier '(a z e r t)) ; -> t
; (dernier '(a)) ; -> a

(define insere (lambda (x n l)
                 (if (= n 0) (cons x l) (cons (car l) (insere x (- n 1) (cdr l))))))

; (insere 'a 3 '(z e r t y u)) ; -> (z e r a t y u)
; (insere 'a 1 '(z e r t y u)) ; -> (z a e r t y u)
; (insere 'a 0 '(z e r t y u)) ; -> (a z e r t y u)
; (insere 'a 6 '(z e r t y u)) ; -> (z e r t y u a)

(define renverse (lambda (l)
                   (if (null? l) l (append (renverse (cdr l)) (list (car l))))))

(renverse '(a b c d)) ; -> (d c b a)
; avec une liste vide
;(renverse '()) ; -> ()