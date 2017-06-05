select
					max(ms.amarillas) as amarillas
				from		dbsancionesjugadores sj
				inner
				join		dbsancionesfallos sf
				on			sj.refsancionesfallos = sf.idsancionfallo
				inner
				join		dbfixture fix
				on			fix.idfixture = sj.reffixture
				inner
                join		dbsancionesfallosacumuladas ms
                on			ms.refsancionesjugadores = sj.idsancionjugador
                inner
                join		dbsancionesfechascumplidas sc
                on			sc.refsancionesfallosacumuladas = ms.idsancionfalloacumuladas
                inner
				join		dbfixture fixc
				on			fixc.idfixture = sc.reffixture
				where		ms.generadaporacumulacion = 1 
							and ms.fechascumplidas = 1
							and sj.refjugadores = 8512
							and fix.reftorneos = 156