
from openai import OpenAI
import os

def obtener_respuesta_chat(prompt):
    # Configura tu clave de API
    api_key = os.environ.get("apikey")

    # Configura la clave de API
    client = OpenAI(api_key=api_key)

    # Crear solicitud de completado de chat
    completion = client.chat.completions.create(
        model="gpt-4",
        messages=[
            {"role": "system", "content": "eres un guia turistico y dame respuestas cortas y concisas en formato json"},
            {"role": "user", "content": prompt},
        ]
    )

    # Devolver la respuesta del modelo
    return dict(completion.choices[0].message)

# Ejemplo de uso
#prompt = "somos una familia de dos adultos y dos niños y queremos visitar Madrid y estraremos dos días, dame un itinerario de las actividades para hacer en Madrid"
#respuesta = obtener_respuesta_chat(prompt)
#print(respuesta)






