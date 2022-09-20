import React, { useState, useEffect, useRef } from 'react';

const FetchProperties = () => {
    const [properties, setProperties] = useState([]);
    const inputRef = useRef();
    console.log('dsass')

    useEffect(() => {
        FetchProperties();
    }, []);

    const fetchProperties = () => {
        fetch('http://localhost:80/index.php/api/property/view/' + inputRef.current.value , {method : 'GET', mode: 'no-cors'})
            .then((response) => response.json())
            .then((actualData) => {
                setProperties(actualData);
            })
            .catch((err) => {
                console.log(err);
            });
    };

    return (
        <div>
            <h1>Properties</h1>
            <div className='item-container'>
                {properties.map((property) => (
                    <div className='card' >
                        <h3>{property.name}</h3>
                        <p>{property.parent}</p>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default FetchProperties;