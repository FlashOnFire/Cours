;; The first three lines of this file were inserted by DrRacket. They record metadata
;; about the language level of this file in a form that our tools can easily process.
#reader(lib "htdp-beginner-abbr-reader.ss" "lang")((modname aaa) (read-case-sensitive #t) (teachpacks ()) (htdp-settings #(#t write repeating-decimal #f #t none #f () #f)))
(define mention
  (lambda (n)
    (cond
      ((>= n 16) "Très bien")
      ((and (< n 16) (>= n 14)) "Bien")
      ((and (< n 14) (>= n 12)) "Assez bien")
      (else "Pas de mention")
      )))

(mention 0)

(define fibo
  (lambda (n)
    (if (<= n 1) 1 (+ (fibo (- n 1)) (fibo (- n 2))))))

(fibo 6)

(define p2
  (lambda (n)
    (if (= 2 n) #T (and (integer? (/ n 2)) (> n 0) (p2 (/ n 2))))))

(p2 32768)

(define syracuse (lambda (u0) (if (= u0 1) #T (if (= (modulo u0 2) 0) (syracuse (/ u0 2)) (syracuse(+ 1 (* 3 u0)))))))

(syracuse 154484674648229255361292518952512982832982186231629452925556565556656556565665555556565456546556286846872666645843654536684146438486464325897458524596545652579846525285285285254127417451852852634846835268645865556384638546888816584668468468444444848648842625685552985298528625652945295862558529852192913852875781492383792949539479723917593729519474277652765267256548618438546846846843848348348646846841651641684681684684648654655685685685686884688878697787968776868765884965747979696757976687684563513563163586548654683538744684354538159156717567517912792526728625685267256785289725952959851920050975082249052952951490497120427907412792740584684864684848545874546464684684684684948648763546876356455486514687946546879465798643546843465435464354613564864684986486846464684684684646846846864846854168468486464684684684643541464986562958581584864846848)


(define dernierelement (lambda (l) (if (null? (cdr l)) (car l) (dernierelement (cdr l)))))
(dernierelement '(1 2 3 4 5 6 7 8 9))

(define echange (lambda (l) (cons (cadr l) (cons (car l) (cddr l)))))

(echange '(1 2 3 4 5 6 7 8 9))

(define estdans (lambda (l n) (if (null? l) #F (if (= (car l) n) #T (estdans (cdr l) n)))))

(estdans '(1 2 3 4 5 6 7 8 9) 11)

(define nieme (lambda (l n) (if (= 0 n) (car l) (nieme (cdr l) (- n 1)))))

(nieme '(1 2 3 4 5 6 7 8 9) 6)

(define insere (lambda (l n e) (if (= n 0) (cons (cons n e) (cdr l)) (cons (car l) (insere (cdr l) (- n 1) e)))))

(insere '(1 2 3 4 5 6 7 8 9) 6 5)

