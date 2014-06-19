import rdflib, sys
g=rdflib.Graph()


g.parse("http://linkedjazz.org/api/people/all/nt", format="nt")


abstracts=rdflib.Graph()
names=rdflib.Graph()

count = 0

all_instruments = []

for s,p,o in g:

	count+=1

	print (count,"/",len(g))

	#we want the names
	if p == rdflib.URIRef("http://xmlns.com/foaf/0.1/name"):

		names.add((s, p, o))


	#we want the abstract if dbpedia has it
	if str(s).find('dbpedia') > -1:

		print ("Doing",str(s).replace('/resource/','/data/') +'.ntriples')

		try:
			dbpedia = rdflib.Graph()
			dbpedia.parse(str(s).replace('/resource/','/data/') +'.ntriples',format='nt')

			found_abstract = False;

			for db_s,db_p,db_o in dbpedia:


				if db_p == rdflib.URIRef("http://dbpedia.org/ontology/abstract") and type(db_o) == rdflib.term.Literal:

					#we only want english right now
					if str(db_o._language) == 'en':

						print ("Adding Abstract")
						abstracts.add((db_s, db_p, db_o))
						found_abstract = True

				#instrument data if there
				if db_p == rdflib.URIRef("http://dbpedia.org/property/instrument"):

					abstracts.add((db_s, db_p, db_o))

					print ("Adding intrument", str(db_o))

					if str(db_o) not in all_instruments:
						all_instruments.append(str(db_o))




			#if we did not find the abstract settle for the comment
			if found_abstract == False:
				print ("Checking for rdf-schema#comment")


				for db_s,db_p,db_o in dbpedia:


					if db_p == rdflib.URIRef("http://www.w3.org/2000/01/rdf-schema#comment") and type(db_o) == rdflib.term.Literal:

						#we only want english right now
						if str(db_o._language) == 'en':

							print ("Adding Comment")
							abstracts.add((db_s, db_p, db_o))





		except (KeyboardInterrupt, SystemExit):
			raise
		except:
			print ("Error loading from DBpedia ", str(s))	
			sys.exit()
				



print (all_instruments)


names.serialize("names.txt", format="nt")
abstracts.serialize("abstracts.nt", format="nt")
