from flask import Flask, request, jsonify
from chat import obtener_respuesta_chat

app = Flask(__name__)

@app.route('/primes/<prompt>', methods=['GET'])  # Usando una cadena como parámetro
def apichatgpt(prompt):
    chat = obtener_respuesta_chat(prompt)
    return chat



@app.route('/formularioActividades', methods=['POST'])
def recibir_datos():
    # Acceder a los datos enviados via POST
    destino = request.form['destino']
    personas = request.form['personas']
    ninos = request.form['ninos']
    preferencias = request.form['preferencias']
    evitar = request.form['evitar']

    query = "queremos viajar a" + destino +  ", somos " + personas + " personas, " + ninos + " ten cuenta que nos interesa " + preferencias + " y deseamos evitar " + evitar + "tambien dame las coordenadas de los lugares a visitar"
    query= "dame 6 actividades tursticas teniendo en cuenta que" +query+ "utiliza estrictamente siguiente formato json:{lugar:"",descripcion:"",coordenadas:""}, respetando que la primera palabra sea lugar, respuetas claras y concisas"
    chat = obtener_respuesta_chat(query)
    return chat

    # Procesar los datos como necesites
    # Por ejemplo, imprimirlos o almacenarlos en una base de datos

    # Enviar una respuesta al cliente

@app.route('/formularioRestaurantes', methods=['POST'])
def recibir_datos_restaurantes():
    # Acceder a los datos enviados via POST
    ciudad = request.form['ciudad']
    zona = request.form['zona']
    ocasion = request.form['ocasion']
    ninos = request.form['ninos']
    preferencias = request.form['preferencias']
    evitar = request.form['evitar']

    query = "estamos en" + ciudad +  ", por la zona de " + zona + " y nos gustaria ir a " + ocasion + "considera que" + ninos + " ten cuenta que nos gusta " + preferencias + " y deseamos evitar sitios de " + evitar + "tambien dame las coordenadas de los lugares a visitar"
    query= "dame 6 actividades restaurantes teniendo en cuenta que" +query+ "utiliza estrictamente siguiente formato json:{lugar:"",descripcion:"",coordenadas:""}, respetando que la primera palabra sea lugar, respuetas claras y concisas"
    chat = obtener_respuesta_chat(query)
    return chat


@app.route('/formularioItinerarios', methods=['POST'])
def recibir_datos_itinerarios():
    # Acceder a los datos enviados via POST
    destino = request.form['destino']
    personas = request.form['personas']
    ninos = request.form['ninos']
    dias = request.form['dias']
    preferencias = request.form['preferencias']
    evitar = request.form['evitar']

    query = "vamos a viajar a" + destino + "estares" +dias+  ", somos " + personas + " personas, " + ninos + " ten cuenta que nos interesa " + preferencias + " y deseamos evitar " + evitar + "tambien dame las coordenadas de los lugares a visitar"
    query=  "Sigue estrictamnete lo indicado en" +query+ "devuelmelo en formato json, que siga estrictamente el formato de que comience siempre por la primera palabra itinerario en minuscula"
    query= query+ r"que siga estrictamente la estructura de interface Actividad {lugar: string;descripcion: string;coordenadas: string;}interface Dia {Manana: Actividad[];Tarde: Actividad[];Noche: Actividad[];}interface Itinerario {dias: Dia[];}. Todo la informacion debe estar en español"
    query= query + "debe tener una actividad turisticas la por la mañana, tarde y noche"
    

    
    chat = obtener_respuesta_chat(query)
    return chat


if __name__ == '__main__':
    app.run(debug=True)
