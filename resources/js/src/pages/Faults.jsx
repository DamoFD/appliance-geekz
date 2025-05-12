import Input from '../components/Input';
import { useState, useEffect } from 'react';
import axiosClient from '../axios-client';
import { IoArrowBack } from "react-icons/io5";
import { useNavigate } from 'react-router-dom';
import { useAppliance } from '../contexts/ApplianceContextProvider';
import { Link } from 'react-router-dom';
import {
  FaRegLightbulb,        // idea / electrical issue
  FaTools,               // classic repair tools
  FaScrewdriver,         // direct repair symbol
  FaWrench,              // general fixing
  FaFan,                 // fans, motors
  FaBolt,                // electrical / power
  FaThermometerHalf,     // heating or cooling issue
  FaRegClock,            // timing / cycles
  FaCogs,                // internal mechanisms
} from "react-icons/fa";

import {
  HiOutlineCog,          // config / gear
  HiOutlineLightningBolt // surge / power issue
} from "react-icons/hi";

import {
  TbBoxModel2,           // physical models / dimensions
  TbPlugConnected,       // power connection
  TbTemperature,         // sensors, thermal issues
  TbDropletHalf,         // water sensor / leaks
  TbWashMachine,         // washer-specific
  TbWindmill,            // airflow, ventilation
} from "react-icons/tb";

import {
  VscWand                // diagnostics / magic fix metaphor
} from "react-icons/vsc";

import { FaArrowRight } from "react-icons/fa6";
import { MdSearch } from "react-icons/md";

const Faults = () => {
    const navigate = useNavigate();
    const back = () => {
        navigate(-1);
    }
    const { appliance } = useAppliance();
    const [search, setSearch] = useState('');
    const [filteredFaults, setFilteredFaults] = useState([]);
    const [loading, setLoading] = useState(true);
    const [faults, setFaults] = useState([]);

    useEffect(() => {
        getFaults();
    }, []);

    const getFaults = () => {
        setLoading(true);
        axiosClient.get(`/faults/`, {
            params: {
                brand: appliance.brand,
                model: appliance.model,
                serial: appliance.serial
            }
        })
            .then(({data}) => {
                setLoading(false);
                setFaults(data.faults);
                setFilteredFaults(data.faults);
            })
            .catch(() => {
                setLoading(false);
                console.error('error fetching faults');
            });
    }

    const icons = [
        FaRegLightbulb,        // idea / electrical issue
        FaTools,               // classic repair tools
        FaScrewdriver,         // direct repair symbol
        FaWrench,              // general fixing
        FaFan,                 // fans, motors
        FaBolt,                // electrical / power
        FaThermometerHalf,     // heating or cooling issue
        FaRegClock,            // timing / cycles
        FaCogs,                // internal mechanisms
        HiOutlineCog,          // config / gear
        HiOutlineLightningBolt, // surge / power issue
        TbBoxModel2,           // physical models / dimensions
        TbPlugConnected,       // power connection
        TbTemperature,         // sensors, thermal issues
        TbDropletHalf,         // water sensor / leaks
        TbWashMachine,         // washer-specific
        TbWindmill,            // airflow, ventilation
        VscWand,                // diagnostics / magic fix metaphor
    ];

    const filter = (query) => {
      setSearch(query);

      if (!query) {
        setFilteredFaults(faults);
      } else {
        const q = query.toLowerCase();
        const filtered = faults.filter((fault) =>
          fault.code.toLowerCase().includes(q) ||
          fault.title.toLowerCase().includes(q)
        );
        setFilteredFaults(filtered);
      }
    };

    return (
        <div className="min-h-screen w-full bg-dark-900 p-8">
            <IoArrowBack onClick={back} className="text-white size-6 cursor-pointer" />
            <h1
                className="font-inter font-bold text-5xl primary-text-gradient mt-4"
            >
                Common<br />Fault Codes
            </h1>
            <div className="w-full mt-4">
                <Input
                    placeholder="Filter..."
                    EndAdornment={MdSearch}
                    value={search}
                    onChange={(e) => filter(e.target.value)}
                />
            </div>
            {loading ? (
                <p className="text-white font-inter text-lg primary-text-gradient mt-4">Loading...</p>
            ) : (
                    <div>
                        {filteredFaults.map((fault, index) => {
                            const Icon = icons[index];

                            return (
                                <div className="grid grid-cols-[1fr_3fr] gap-4 text-white mt-8 w-full font-inter" key={index}>
                                    <p className="primary-text-gradient font-bold text-3xl">{fault.code}</p>
                                    <p className="font-bold text-3xl">{fault.title}</p>
                                    <Icon className="size-6 text-[#1796BD]" />
                                    <p className="text-secondary">{fault.solution}</p>
                                    <div />
                                    <Link to={`/app/chat?code=${fault.code}`} className="text-[#1796BD] flex items-center cursor-pointer">
                                        <p className="underline">Chat about this error</p>
                                        <FaArrowRight className="size-4 ml-2" />
                                    </Link>
                                </div>
                            );
                        })}
                    </div>
                )
            }
        </div>
    );
}

export default Faults;
