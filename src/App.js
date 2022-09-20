import {useState} from 'react';
import {useRef} from "react";
import {render} from "react-dom";

const App = () => {
    const [properties, setProperties] = useState([]);
    const self = this;
    const inputRef = useRef();

    const handleClick = async () => {
        try {

            if (inputRef.current.value.length <= 0) {
                throw new Error(`Error! input empty`);
            }

            const response = await fetch('http://localhost:80/index.php/api/property/view/' + inputRef.current.value, {
                method: 'GET',
                headers: {
                    Accept: 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error(`Error! status: ${response.statusText}`);
            }

            const result = await response.json();

            setProperties(result);
        } catch (err) {
            alert((err.message));
        }
    };

    return (
        <div className="App">
            <div className="search_option">
                <div className="form-floating mb-3">
                    <input
                        ref={inputRef}
                        type="text"
                        className="form-control"
                        id="search_property"
                        placeholder="Building 1"></input>
                    <label htmlFor="search_property">Search by property name</label>
                </div>
            </div>
            <button onClick={handleClick}
                    type="button" id="add" className="btn btn-secondary btn-lg">Get
            </button>

            <div className='item-container'>
                {properties.map((property) => (
                    <div className='card' >
                        <pre>
                            {JSON.stringify(property)}
                        </pre>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default App;