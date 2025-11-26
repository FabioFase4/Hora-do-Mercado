export class ApiService
{   
    #token;

    constructor (token)
    {
        this.#token = token;
    }

    async simpleGet(uri) 
    {
        try 
        {
            const response = await fetch(uri); 
            const jsonObj = await response.json();
            console.log("GET:", uri, jsonObj);
            return jsonObj; 
        } 
        catch (error) 
        {
            console.error("Erro ao buscar dados:", error.message); 
            return []; 
        }
    }

    async get(uri) 
    {
        try 
        {
            const headers = {
                "Content-Type": "application/json"
            };
            if (this.#token) 
            {
                headers["Authorization"] = `Bearer ${this.#token}`;
            }
            const response = await fetch(uri, {
                method: "GET",
                headers: headers
            });
            const jsonObj = await response.json(); 
            console.log("GET:", uri, jsonObj); 
            return jsonObj; 
        } 
        catch (error) 
        {
            console.error("Erro ao buscar dados:", error.message);
            return []; 
        }
    }

    async getById(uri, id) 
    {
        try {
            const headers = {
                "Content-Type": "application/json"
            };
            if (this.#token) {
                headers["Authorization"] = `Bearer ${this.#token}`;
            }
       
            const fullUri = `${uri}/${id}`;
            const response = await fetch(fullUri, {
                method: "GET",
                headers: headers
            });
            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }
            const jsonObj = await response.json();
            console.log("GET BY ID:", fullUri, jsonObj);
            return jsonObj;
        } 
        catch (error) 
        {
            console.error("Erro ao buscar por ID:", error.message);
            return null;
        }
    }

    async post(uri, jsonObject) 
    {
        let jsonObj;
        try 
        {
            const headers = {
                "Content-Type": "application/json"
            };
            if (this.#token) {
                headers["Authorization"] = `Bearer ${this.#token}`;
            }

            const response = await fetch(uri, {
                method: "POST",
                headers: headers,
                body: JSON.stringify(jsonObject)
            });
            jsonObj = await response.json();
            console.log("POST: ", uri, jsonObj); 
        } 
        catch (error) 
        {
            console.error("Erro ao buscar dados:", error.message);
            
        }
        return jsonObj; 
    }

    async put(uri, id, jsonObject) 
    {
        try 
        {
            const headers = {
                "Content-Type": "application/json"
            };
            if (this.#token) {
                headers["Authorization"] = `Bearer ${this.#token}`;
            }
            
            const fullUri = `${uri}/${id}`;
            const response = await fetch(fullUri, {
                method: "PUT",
                headers: headers,
                body: JSON.stringify(jsonObject)
            });
            const jsonObj = await response.json();
            console.log("PUT:", fullUri, jsonObj);
            return jsonObj;
        } 
        catch (error) 
        {
            console.error("Erro ao enviar dados:", error.message);
            return null; 
        }
    }

    async delete(uri, id) 
    {
        try 
        {
            const headers = {
                "Content-Type": "application/json"
            };
            if (this.#token) {
                headers["Authorization"] = `Bearer ${this.#token}`;
            }

            const fullUri = `${uri}/${id}`;

            const response = await fetch(fullUri, {
                method: "DELETE",
                headers: headers
            });

            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }

            const jsonObj = await response.json().catch(() => null);
            console.log("DELETE:", fullUri, jsonObj);
            return jsonObj;
        } 
        catch (error) 
        {
            console.error("Erro ao deletar dados:", error.message);
            return null; 
        }
    }
}